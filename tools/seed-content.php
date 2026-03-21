<?php
/**
 * Envision Legal – Content Seeder
 *
 * Run via WP-CLI:
 *   wp eval-file tools/seed-content.php
 *
 * Requirements:
 *   - WordPress must be fully bootstrapped (WP-CLI handles this).
 *   - The running user must have capability to create/edit posts.
 *   - curl or allow_url_fopen must be enabled for image sideloading.
 *
 * @package EnvisionLegal
 */

if ( ! defined( 'ABSPATH' ) ) {
	// When run via WP-CLI, ABSPATH is defined before this file loads.
	echo "Error: This script must be run inside a WordPress environment via WP-CLI.\n";
	echo "Usage: wp eval-file tools/seed-content.php\n";
	exit( 1 );
}

// ── Helpers ───────────────────────────────────────────────────────────────────

/**
 * Create or update a page. Returns the post ID.
 *
 * @param array $args {
 *   @type string $title      Post title.
 *   @type string $slug       Post name / slug.
 *   @type string $content    Post content HTML.
 *   @type string $status     Post status (default: publish).
 *   @type string $template   Page template filename (optional).
 *   @type string $date       Post date in 'Y-m-d' format (optional).
 *   @type string $image_url  Remote featured image URL (optional).
 * }
 * @return int Post ID.
 */
function el_seed_page( array $args ): int {
	$defaults = array(
		'title'    => '',
		'slug'     => '',
		'content'  => '',
		'status'   => 'publish',
		'template' => '',
		'date'     => '',
		'image_url' => '',
	);
	$args = array_merge( $defaults, $args );

	$existing = get_page_by_path( $args['slug'], OBJECT, 'page' );

	$post_data = array(
		'post_type'    => 'page',
		'post_title'   => $args['title'],
		'post_name'    => $args['slug'],
		'post_content' => $args['content'],
		'post_status'  => $args['status'],
	);

	if ( $args['date'] ) {
		$post_data['post_date'] = $args['date'] . ' 09:00:00';
	}

	if ( $existing ) {
		$post_data['ID'] = $existing->ID;
		$post_id = wp_update_post( $post_data, true );
	} else {
		$post_id = wp_insert_post( $post_data, true );
	}

	if ( is_wp_error( $post_id ) ) {
		WP_CLI::warning( "Failed to upsert page '{$args['slug']}': " . $post_id->get_error_message() );
		return 0;
	}

	if ( $args['template'] ) {
		update_post_meta( $post_id, '_wp_page_template', $args['template'] );
	}

	if ( $args['image_url'] ) {
		el_sideload_image( $args['image_url'], $post_id );
	}

	WP_CLI::success( "Upserted page '{$args['slug']}' (ID: {$post_id})" );
	return $post_id;
}

/**
 * Create or update a post. Returns the post ID.
 *
 * @param array $args {
 *   @type string $title      Post title.
 *   @type string $slug       Post name / slug.
 *   @type string $content    Post content HTML.
 *   @type string $status     Post status (default: publish).
 *   @type string $date       Post date in 'Y-m-d' format (optional).
 *   @type string $image_url  Remote featured image URL (optional).
 *   @type array  $categories Array of category names.
 *   @type array  $tags       Array of tag slugs/names.
 * }
 * @return int Post ID.
 */
function el_seed_post( array $args ): int {
	$defaults = array(
		'title'      => '',
		'slug'       => '',
		'content'    => '',
		'status'     => 'publish',
		'date'       => '',
		'image_url'  => '',
		'categories' => array(),
		'tags'       => array(),
	);
	$args = array_merge( $defaults, $args );

	$existing = get_page_by_path( $args['slug'], OBJECT, 'post' );

	$post_data = array(
		'post_type'    => 'post',
		'post_title'   => $args['title'],
		'post_name'    => $args['slug'],
		'post_content' => $args['content'],
		'post_status'  => $args['status'],
	);

	if ( $args['date'] ) {
		$post_data['post_date'] = $args['date'] . ' 09:00:00';
	}

	// Resolve category IDs
	if ( ! empty( $args['categories'] ) ) {
		$cat_ids = array();
		foreach ( $args['categories'] as $cat_name ) {
			$cat = get_term_by( 'name', $cat_name, 'category' );
			if ( ! $cat ) {
				$result = wp_insert_term( $cat_name, 'category' );
				if ( ! is_wp_error( $result ) ) {
					$cat_ids[] = (int) $result['term_id'];
				}
			} else {
				$cat_ids[] = (int) $cat->term_id;
			}
		}
		$post_data['post_category'] = $cat_ids;
	}

	if ( $existing ) {
		$post_data['ID'] = $existing->ID;
		$post_id = wp_update_post( $post_data, true );
	} else {
		$post_id = wp_insert_post( $post_data, true );
	}

	if ( is_wp_error( $post_id ) ) {
		WP_CLI::warning( "Failed to upsert post '{$args['slug']}': " . $post_id->get_error_message() );
		return 0;
	}

	// Tags
	if ( ! empty( $args['tags'] ) ) {
		wp_set_post_tags( $post_id, $args['tags'], false );
	}

	if ( $args['image_url'] ) {
		el_sideload_image( $args['image_url'], $post_id );
	}

	WP_CLI::success( "Upserted post '{$args['slug']}' (ID: {$post_id})" );
	return $post_id;
}

/**
 * Download a remote image and set it as the featured image for a post.
 *
 * @param string $url     Remote image URL.
 * @param int    $post_id Post ID.
 * @return int Attachment ID on success, 0 on failure.
 */
function el_sideload_image( string $url, int $post_id ): int {
	if ( empty( $url ) || ! $post_id ) {
		return 0;
	}

	// Already has a featured image? Skip to avoid duplicates.
	if ( has_post_thumbnail( $post_id ) ) {
		return (int) get_post_thumbnail_id( $post_id );
	}

	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = download_url( $url );
	if ( is_wp_error( $tmp ) ) {
		WP_CLI::warning( "  Could not download image '{$url}': " . $tmp->get_error_message() );
		return 0;
	}

	$file_array = array(
		'name'     => basename( wp_parse_url( $url, PHP_URL_PATH ) ),
		'tmp_name' => $tmp,
	);

	$attachment_id = media_handle_sideload( $file_array, $post_id );

	if ( file_exists( $tmp ) ) {
		@unlink( $tmp ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}

	if ( is_wp_error( $attachment_id ) ) {
		WP_CLI::warning( "  Could not sideload image '{$url}': " . $attachment_id->get_error_message() );
		return 0;
	}

	set_post_thumbnail( $post_id, $attachment_id );
	WP_CLI::log( "  Featured image set (attachment ID: {$attachment_id})" );
	return $attachment_id;
}

// ── Content Definitions ───────────────────────────────────────────────────────
// Note: post_content preserves Squarespace HTML markup.
// Images: replace placeholder URLs with actual Squarespace CDN URLs from export.

$pages = array(

	array(
		'title'    => 'Home',
		'slug'     => 'home',
		'template' => 'front-page.php',
		'content'  => '',  // front-page.php handles display; content is optional editorial copy
	),

	array(
		'title'    => 'About',
		'slug'     => 'about',
		'template' => 'page-about.php',
		'content'  => <<<'HTML'
<h2>We Are Envision Legal</h2>
<p>Envision Legal is a boutique commercial law firm based in South-West Sydney. We work with entrepreneurs, growing businesses and established companies who need practical, commercial legal advice delivered by lawyers who understand how business actually works.</p>
<p>Founded on the belief that great legal advice shouldn't require a big-firm budget, we offer the expertise of seasoned commercial lawyers in a lean, accessible format. Whether you're buying a business, launching a startup, protecting your brand or navigating a contract dispute, we're the team in your corner.</p>
<h3>Our Approach</h3>
<p>We don't believe in legal advice for its own sake. Every piece of advice we give is designed to help you make better decisions, protect your interests and move your business forward. We ask the commercial questions, not just the legal ones—because that's how you get to the right outcome.</p>
HTML,
	),

	array(
		'title'    => 'Contact',
		'slug'     => 'contact',
		'template' => 'page-contact.php',
		'content'  => '',  // page-contact.php contains the form; CF7/WPForms shortcode can be added here
	),

	array(
		'title'    => 'Practice Areas',
		'slug'     => 'practiceareas',
		'template' => 'page-practiceareas.php',
		'content'  => <<<'HTML'
<p>We focus exclusively on commercial law—which means you receive deep, specialised advice rather than a generalist perspective. Our practice areas span the full lifecycle of a business, from early-stage legal foundations to growth, exits and everything in between.</p>
HTML,
	),

	array(
		'title'    => 'Terms of Use',
		'slug'     => 'termsofuse',
		'template' => 'page-termsofuse.php',
		'content'  => '',  // Template provides default placeholder terms
	),

	array(
		'title'    => 'Privacy Policy',
		'slug'     => 'privacypolicy',
		'template' => 'page-privacypolicy.php',
		'content'  => '',  // Template provides default placeholder policy
	),

	array(
		'title'    => 'South West Sydney Lawyers',
		'slug'     => 'south-west-sydney-lawyers',
		'template' => 'page-south-west-sydney-lawyers.php',
		'content'  => <<<'HTML'
<h2>Commercial Lawyers Serving South-West Sydney</h2>
<p>Envision Legal is proud to be part of the South-West Sydney business community. We understand the unique challenges facing businesses in growth suburbs like Campbelltown, Liverpool, Parramatta, Bankstown and Fairfield—because we've worked alongside them for years.</p>
<p>From sole traders setting up their first business to mid-sized companies managing complex commercial relationships, we offer the same senior-level legal expertise regardless of the size of your matter.</p>
HTML,
	),

);

$posts = array(

	array(
		'title'      => 'Selling Your Business: 5 Legal Red Flags That Kill Deals',
		'slug'       => 'selling-your-business-5-legal-red-flags-that-kill-deals',
		'date'       => '2024-03-15',
		'categories' => array( 'Business Sales', 'Commercial Law' ),
		'tags'       => array( 'business sales', 'due diligence', 'commercial law' ),
		'image_url'  => '',  // Replace with actual Squarespace CDN URL from export
		'content'    => <<<'HTML'
<p>You've built something valuable. Now you want to sell it. Whether you're passing the business on to a buyer you've found through a broker or directly negotiating with a competitor, the legal process of selling a business is where deals live or die.</p>

<p>Here are five legal red flags that commonly derail business sales—and what you can do to get ahead of them.</p>

<h2>1. Undisclosed Liabilities</h2>
<p>Buyers conduct due diligence for a reason. If your business carries undisclosed debts, pending litigation, tax obligations or personal guarantees, a competent buyer's lawyer will find them. The moment they do, you lose negotiating power—and trust.</p>
<p><strong>What to do:</strong> Before you go to market, prepare a clean liability disclosure schedule. Include all known claims, pending disputes, ATO arrangements and bank covenants. Surprises kill deals; disclosures don't.</p>

<h2>2. Key Man Risk – No Succession in Place</h2>
<p>If the business depends entirely on you—your relationships, your knowledge, your client base—buyers will see a risk cliff the moment you step away. This is called "key man risk," and it's one of the most common reasons valuations crater or conditions precedent become impossible to satisfy.</p>
<p><strong>What to do:</strong> Before sale, document processes, transition key relationships to staff, and demonstrate that the business can operate independently. If a transition period is required, negotiate the terms carefully—including remuneration, authority and exit triggers.</p>

<h2>3. Intellectual Property Not Properly Owned</h2>
<p>Who owns the software, the brand, the client data, the website content? In many owner-operated businesses, IP ownership is messy—work was done by contractors without IP assignment clauses, trademarks were never registered, or the domain name is in someone's personal name.</p>
<p><strong>What to do:</strong> Conduct an IP audit before sale. Assign all IP to the business entity (not to you personally), register trademarks that are material to the business, and ensure all contractor agreements include IP assignment clauses.</p>

<h2>4. Restraint of Trade Issues</h2>
<p>Buyers want to know you won't walk out the door and set up a competing business down the street. A well-drafted restraint of trade clause is standard—but if it's too broad or too long, it may be unenforceable under Australian law.</p>
<p><strong>What to do:</strong> Get advice on what restraint is reasonable before the negotiation starts. Courts will only uphold restraints that go no further than necessary to protect the buyer's legitimate interests. Strike the right balance upfront, or you'll be renegotiating at the 11th hour.</p>

<h2>5. Employment Entitlements – The Silent Liability</h2>
<p>Accrued leave entitlements, superannuation shortfalls, contractors who might be classified as employees—these can add up to material liabilities that only surface during due diligence.</p>
<p><strong>What to do:</strong> Run a payroll audit before you start the sale process. Ensure all employee entitlements are up to date, superannuation is current, and employment contracts are compliant with the Fair Work Act. If you've been treating workers as contractors who should legally be employees, address this before the deal—not during it.</p>

<h2>Ready to Sell? Get Legal Advice Early</h2>
<p>The businesses that sell well are the ones that prepare well. Engaging a commercial lawyer at the start of the sale process—not just to review the contract at the end—can add real dollars to your outcome and protect you from costly surprises.</p>
<p>At Envision Legal, we work with business owners at every stage of the sale process. <a href="/contact">Get in touch</a> to book a free initial consultation.</p>
HTML,
	),

	array(
		'title'      => 'Startup Legals: What You Need Before You Launch',
		'slug'       => 'startup-legals',
		'date'       => '2024-02-20',
		'categories' => array( 'Startups', 'Commercial Law' ),
		'tags'       => array( 'startups', 'co-founder agreement', 'shareholders agreement' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>You've got the idea. You've got the co-founder. You've got the early customers lined up. The last thing on your mind is legal paperwork—but it should be.</p>

<p>Getting your legal foundation right early costs a fraction of what it costs to fix later. Here's what most startups need before they launch—or very soon after.</p>

<h2>1. Choose the Right Structure</h2>
<p>Sole trader? Partnership? Company? Trust? Each structure has different implications for tax, liability, asset protection and investor readiness. Most VC-backed startups use a company structure—and for good reason. Investors expect it, it's easier to issue shares, and it separates your personal assets from the business.</p>
<p>If you're raising capital, you need a company. If you're bootstrapping, a simpler structure may work—for now.</p>

<h2>2. Co-Founder Agreement</h2>
<p>The most common startup legal disaster: two founders with different visions, no agreement in place, and everything falling apart when the relationship breaks down. A co-founder agreement (or shareholders' agreement) should cover:</p>
<ul>
<li>Equity split and vesting schedule</li>
<li>Roles and responsibilities</li>
<li>Decision-making process (and deadlock resolution)</li>
<li>What happens if one co-founder leaves</li>
<li>IP ownership</li>
<li>Competition and restraint during and after the venture</li>
</ul>
<p>Don't skip this because you trust each other. The agreement isn't about distrust—it's about clarity.</p>

<h2>3. IP Assignment</h2>
<p>Every piece of code, design, content and process created for the startup should be legally owned by the startup entity—not by the individual founders or any contractor. Make sure:</p>
<ul>
<li>Founders assign any pre-existing IP they're contributing</li>
<li>All contractor agreements include IP assignment clauses</li>
<li>Employee contracts include IP assignment and confidentiality obligations</li>
</ul>

<h2>4. Privacy and Data Compliance</h2>
<p>If you're collecting personal information—email addresses, payment details, usage data—you have obligations under the Privacy Act 1988 (Cth). You'll need a privacy policy, appropriate data security measures, and a plan for handling data breaches.</p>

<h2>5. Investor Readiness</h2>
<p>If you're raising money, investors will expect clean cap table documentation, a signed shareholders' agreement, and ideally a SAFE or convertible note template. Getting these right from the start signals that you're a serious operator—and saves the legal fees of cleaning up a mess later.</p>

<h2>Don't Wait Until It Hurts</h2>
<p>The best time to get your startup legals in order is before you launch. The second best time is right now. <a href="/contact">Contact Envision Legal</a> to discuss a startup legal package tailored to your stage and budget.</p>
HTML,
	),

	array(
		'title'      => 'Trademarks: Why Your Brand Is Worth Protecting',
		'slug'       => 'trademarks',
		'date'       => '2024-01-10',
		'categories' => array( 'Intellectual Property', 'Commercial Law' ),
		'tags'       => array( 'trademarks', 'IP', 'brand protection' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>Your business name. Your logo. Your tagline. These are more than marketing assets—they're legally protectable intellectual property. And if you don't protect them, someone else might.</p>

<h2>What Is a Trademark?</h2>
<p>A trademark is a sign—a word, phrase, logo, shape, colour or combination of these—that distinguishes your goods or services from those of others. In Australia, trademarks are registered with IP Australia and give you exclusive rights to use the mark for the relevant goods and services in the relevant classes.</p>

<h2>Why Register?</h2>
<p>Registration isn't mandatory. You can build common law trademark rights simply by using a mark in trade. But registration gives you:</p>
<ul>
<li><strong>Exclusive rights</strong> — No one else can use a substantially similar mark for similar goods or services without your permission.</li>
<li><strong>Legal standing</strong> — Registration makes it significantly easier to enforce your rights and seek damages.</li>
<li><strong>Commercial value</strong> — Registered trademarks can be licensed, sold or used as security—they're assets on your balance sheet.</li>
<li><strong>Australian Consumer Law protection</strong> — Registered marks make misleading and deceptive conduct claims more straightforward.</li>
</ul>

<h2>The Registration Process</h2>
<p>A trademark application in Australia involves:</p>
<ol>
<li>Clearance search to check no conflicting marks exist</li>
<li>Identifying the correct Nice Classification (goods/services classes)</li>
<li>Filing the application with IP Australia</li>
<li>Examination period (typically 3–4 months)</li>
<li>Opposition period (if no opposition, registration is confirmed)</li>
</ol>
<p>The process typically takes 7–13 months from application to registration. Act early—the effective date of protection runs from your application date, not your registration date.</p>

<h2>Domain Names, Business Names and Trademarks Are Not the Same Thing</h2>
<p>Registering a business name with ASIC or a domain name through a registrar does not give you trademark rights. These are separate systems. Business name registration simply prevents another business from trading under the identical name—but it doesn't stop them from using a similar name or logo in a way that could confuse customers.</p>

<h2>Ready to Protect Your Brand?</h2>
<p>If you've invested in building a brand, protect it. Trademark registration is one of the most cost-effective legal investments a business can make. <a href="/contact">Contact Envision Legal</a> to discuss your trademark strategy.</p>
HTML,
	),

	array(
		'title'      => 'Unfair Contract Terms: What Every Business Owner Needs to Know',
		'slug'       => 'unfair-contract-terms',
		'date'       => '2023-11-05',
		'categories' => array( 'Commercial Law', 'Contracts' ),
		'tags'       => array( 'unfair contract terms', 'ACL', 'small business' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>The unfair contract terms (UCT) regime under the Australian Consumer Law (ACL) has been extended and strengthened. From 9 November 2023, the regime now applies to more businesses and carries penalties for including unfair terms in standard-form contracts.</p>

<h2>What Changed?</h2>
<p>Key changes to the UCT regime include:</p>
<ul>
<li><strong>Broader coverage</strong> — The small business threshold for standard-form contracts increased from contracts worth less than $300,000 (or $1 million for contracts longer than 12 months) to any standard-form contract with a business that employs fewer than 100 people or has an annual turnover of less than $10 million.</li>
<li><strong>Penalties</strong> — Courts can now impose significant financial penalties for including or relying on unfair contract terms. Penalties can reach $50 million for corporations, or higher amounts calculated by reference to the benefit obtained.</li>
<li><strong>Voidable, not just void</strong> — Courts can now make orders about the whole contract, not just the offending term.</li>
</ul>

<h2>What Is an Unfair Term?</h2>
<p>A term is "unfair" if it:</p>
<ol>
<li>Would cause a significant imbalance in the parties' rights and obligations</li>
<li>Is not reasonably necessary to protect the legitimate interests of the party who would be advantaged by the term</li>
<li>Would cause detriment (financial or otherwise) to a party if relied on</li>
</ol>
<p>Common examples of potentially unfair terms include: unilateral variation clauses (one party can change the contract without notice), broad indemnification provisions, automatic renewal clauses, and terms allowing one party to terminate without cause.</p>

<h2>What Should You Do?</h2>
<p>If you use standard-form contracts in your business—whether with customers, suppliers or business partners—you should:</p>
<ol>
<li>Audit your standard-form contracts to identify potentially unfair terms</li>
<li>Review whether the UCT regime applies to your contracts</li>
<li>Amend or remove terms that are likely to be considered unfair</li>
<li>If you are on the receiving end of a contract with unfair terms, understand your rights</li>
</ol>

<h2>Get Your Contracts Reviewed</h2>
<p>The UCT changes are significant and the penalties are real. <a href="/contact">Contact Envision Legal</a> to have your standard-form contracts reviewed and updated for compliance.</p>
HTML,
	),

	array(
		'title'      => 'Why Everyone Is Talking About Fractional Counsel (And How It Fits Your World)',
		'slug'       => 'why-everyone-is-talking-about-fractional-counsel-and-how-it-fits-your-world',
		'date'       => '2023-09-18',
		'categories' => array( 'Commercial Law', 'Business Strategy' ),
		'tags'       => array( 'fractional counsel', 'in-house legal', 'general counsel' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>The fractional economy is everywhere. Fractional CFOs. Fractional CMOs. Fractional HR directors. And increasingly: Fractional General Counsel (GC).</p>

<p>For growing businesses that aren't ready for a full-time in-house lawyer but have outgrown an ad hoc, transactional relationship with an external firm, fractional counsel is the answer that's been missing from the market.</p>

<h2>What Is Fractional General Counsel?</h2>
<p>Fractional GC is a model where a senior commercial lawyer provides ongoing legal support to your business on a part-time or retainer basis. Rather than billing by the hour for discrete matters, the lawyer is embedded in your business—attending leadership meetings, reviewing contracts as they arise, advising on strategic decisions and building institutional knowledge of your business over time.</p>

<p>The key difference from a traditional law firm relationship: the lawyer is on your team, not just on your file.</p>

<h2>Who Is It For?</h2>
<p>Fractional GC works best for businesses that:</p>
<ul>
<li>Have a regular volume of contracts, negotiations and legal issues—enough to justify a retainer, but not enough to justify a full-time salary</li>
<li>Are scaling quickly and want legal input integrated into business decisions, not added on as an afterthought</li>
<li>Have been burned by slow, expensive law firm billing and want a more predictable cost structure</li>
<li>Value having a lawyer who understands their business, their industry and their risk appetite</li>
</ul>
<p>Typically, this means scale-ups, mid-market businesses with $5M–$50M in revenue, PE-backed portfolio companies, and businesses preparing for a capital raise or sale.</p>

<h2>What Does It Cost?</h2>
<p>Fractional GC arrangements are typically structured as a monthly retainer covering a set number of hours or matters per month. The cost is a fraction of the cost of a full-time in-house lawyer—typically $3,000–$10,000 per month depending on scope—and far more predictable than an hourly billing arrangement with an external firm.</p>

<h2>The Envision Legal Approach</h2>
<p>Our Fractional GC service is designed for businesses that want a real commercial partner—not just a contract reviewer. We embed ourselves in your team, attend your leadership meetings (in person or virtually), and make sure legal considerations are built into your business decisions from the start.</p>

<p>Interested? <a href="/contact">Let's talk</a> about whether Fractional GC is right for your business.</p>
HTML,
	),

	array(
		'title'      => 'Why Your Shareholders\' Agreement Matters: The Ultimate Asset Protection Move',
		'slug'       => 'why-your-shareholders-agreement-matters-the-ultimate-asset-protection-move',
		'date'       => '2023-07-22',
		'categories' => array( 'Commercial Law', 'Business Structure' ),
		'tags'       => array( 'shareholders agreement', 'asset protection', 'business structure' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>If you own shares in a company with other people and you don't have a shareholders' agreement, you're taking one of the biggest risks available to you in business. And most people don't even realise it.</p>

<h2>What Is a Shareholders' Agreement?</h2>
<p>A shareholders' agreement is a contract between the shareholders of a company. It sits alongside the company's constitution and governs how the shareholders will deal with each other in relation to the company.</p>

<p>Unlike the constitution—which is a public document and must comply with the Corporations Act—a shareholders' agreement is private, flexible and can address any issue the shareholders agree is important.</p>

<h2>Why Does It Matter?</h2>
<p>Without a shareholders' agreement, you're governed by the company's constitution (which, if you incorporated through ASIC's online portal, is probably the replaceable rules—a generic framework that doesn't address the specific needs of your business) and the default provisions of the Corporations Act.</p>

<p>This means that critical questions—like what happens when shareholders can't agree, or how shares can be transferred, or who controls key decisions—are answered by a generic legal framework that wasn't designed with your business in mind.</p>

<h2>What Should a Shareholders' Agreement Cover?</h2>
<p>A well-drafted agreement should address:</p>
<ul>
<li><strong>Decision-making</strong> — Which decisions require unanimous or majority approval? What matters can the board decide without shareholder input?</li>
<li><strong>Deadlock resolution</strong> — If shareholders can't agree on a material decision, what happens? A Russian roulette clause? A valuation mechanism? A buy-sell arrangement?</li>
<li><strong>Share transfers</strong> — Who can shareholders sell to? Pre-emptive rights (rights of first refusal) are standard—but the mechanism matters.</li>
<li><strong>Exit events</strong> — Tag-along rights (minority shareholders can "tag along" on a sale by a majority) and drag-along rights (majority can compel minority to join a sale) are essential for clean exits.</li>
<li><strong>Vesting</strong> — If a co-founder leaves early, do they keep all their shares? A vesting schedule tied to continued involvement is standard in any sophisticated agreement.</li>
<li><strong>Restraints</strong> — What can shareholders do after they leave?</li>
<li><strong>Funding obligations</strong> — Are shareholders obliged to contribute capital? On what terms?</li>
<li><strong>Management roles</strong> — What are the obligations of shareholders who are also employees or directors?</li>
</ul>

<h2>When Should You Put One in Place?</h2>
<p>Ideally: before you start the business. The conversation is easy when everyone is aligned and optimistic about the future. It becomes significantly harder—and more expensive—when there's already a dispute or when one shareholder wants to exit and there's no agreed mechanism.</p>

<p>If you're already in business without one: now. Today. Don't wait until you need it.</p>

<h2>Don't DIY This</h2>
<p>Shareholders' agreements are not the place for a template you found online. The devil is in the detail—particularly around valuation mechanisms, deadlock triggers and exit provisions. A poorly drafted clause can be worse than no clause at all.</p>

<p><a href="/contact">Contact Envision Legal</a> to discuss drafting or reviewing a shareholders' agreement for your company.</p>
HTML,
	),

	array(
		'title'      => 'Secret Stuff: Behind the Scenes at Envision Legal',
		'slug'       => 'secret-stuff',
		'date'       => '2023-05-01',
		'categories' => array( 'News' ),
		'tags'       => array( 'about us', 'news' ),
		'image_url'  => '',
		'content'    => <<<'HTML'
<p>Sometimes the most interesting things happening in a law firm are the things you never hear about publicly. Client confidentiality means we can't share the specific stories—but we can share the patterns we see.</p>

<p>This post is a behind-the-scenes look at the kinds of problems we help solve every day—and why getting in early makes all the difference.</p>

<h2>The Deal That Almost Didn't Happen</h2>
<p>A client came to us three weeks from settlement on a business sale. The buyer's due diligence had uncovered an undisclosed liability—a supplier dispute that the seller had forgotten about. The deal was in jeopardy.</p>
<p>We negotiated an escrow arrangement that satisfied the buyer's concerns without blowing up the deal. Settlement happened on time. Everyone went home happy. But it took three weeks of intense negotiation that could have been avoided with better preparation upfront.</p>

<h2>The Co-Founder Split</h2>
<p>Two founders. Five years in business. No shareholders' agreement. One wanted to exit. The other didn't want to buy them out at the price they were asking. Without an agreed valuation mechanism, they were headed for litigation.</p>
<p>We helped them negotiate a buy-sell arrangement and structured the exit in a way that worked for both parties. It wasn't easy—but it was possible. With a shareholders' agreement in place from day one, it would have been automatic.</p>

<h2>The Trademark That Wasn't</h2>
<p>A business owner had been trading under a brand name for three years. A competitor registered the trademark. Suddenly, the original business owner had to rebrand or face legal action—despite being the original user of the name.</p>
<p>Lesson: common law trademark rights exist, but they're hard to prove and expensive to enforce. Register your trademark. It's not optional.</p>

<h2>The Point</h2>
<p>Legal problems almost always start small. A conversation that doesn't quite land right. A contract that doesn't quite cover all the scenarios. A handshake deal where both parties remember different things.</p>
<p>Our job is to help you spot these problems early—before they become expensive. <a href="/contact">Get in touch</a> if you'd like to talk through anything in your business.</p>
HTML,
	),

);

// ── Run the seeder ─────────────────────────────────────────────────────────────

WP_CLI::log( '' );
WP_CLI::log( '=== Envision Legal Content Seeder ===' );
WP_CLI::log( '' );
WP_CLI::log( '--- Seeding Pages ---' );

$home_id = 0;

foreach ( $pages as $page_args ) {
	$id = el_seed_page( $page_args );
	if ( 'home' === $page_args['slug'] ) {
		$home_id = $id;
	}
}

// Set front page
if ( $home_id ) {
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $home_id );
	WP_CLI::success( "Front page set to page ID: {$home_id}" );
}

WP_CLI::log( '' );
WP_CLI::log( '--- Seeding Posts ---' );

foreach ( $posts as $post_args ) {
	el_seed_post( $post_args );
}

WP_CLI::log( '' );
WP_CLI::success( 'Content seeding complete!' );
WP_CLI::log( '' );
WP_CLI::log( 'Next steps:' );
WP_CLI::log( '  1. Go to WP Admin → Settings → Reading and confirm the front page is set.' );
WP_CLI::log( '  2. Go to Appearance → Menus and assign a menu to the Primary Navigation location.' );
WP_CLI::log( '  3. Go to Appearance → Customize to set your logo, phone, email and address.' );
WP_CLI::log( '  4. Review each page and update the content with final copy.' );
WP_CLI::log( '  5. Add featured images to posts (or update image_url values above and re-run).' );
WP_CLI::log( '' );
