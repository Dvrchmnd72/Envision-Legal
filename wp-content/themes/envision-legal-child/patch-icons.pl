use strict;
use warnings;

local $/;
my $file = 'front-page.php';
open my $fh, '<', $file or die "Read $file: $!";
my $s = <$fh>;
close $fh;

sub swap_icon_after_title {
  my ($title, $new_path) = @_;
  # find the block for the array item by matching the title line, then replace the icon line inside that item
  $s =~ s{
    ('title'\s*=>\s*__\(\s*'\Q$title\E'.*?\n)      # title line
    (.*?\n)*?                                      # other lines in item
    (\s*'icon'\s*=>\s*)'[^']*'(\s*,)               # icon line
  }{
    my $t = $1;
    my $mid = $2 // '';
    my $pre = $3;
    my $comma = $4;
    $t . $mid . $pre . "'" . $new_path . "'" . $comma
  }gexs;
}

swap_icon_after_title('Business Contracts',
  q{<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 13h8v2H8v-2zm0-4h5v2H8V9z"/>}
);

swap_icon_after_title('Business Sales & Acquisitions',
  q{<path d="M21 10.5l-4.2-4.2a2 2 0 0 0-2.83 0l-1.17 1.17a2 2 0 0 1-2.83 0L8.8 6.27a2 2 0 0 0-2.83 0L3 9.24l4.1 4.1a2 2 0 0 0 2.83 0l.35-.35.7.7-.35.35a2 2 0 0 0 0 2.83l.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l1.06-1.06a2 2 0 0 0 0-2.83l-2.47-2.47 1.06-1.06L21 10.5z"/>}
);

swap_icon_after_title('Intellectual Property',
  q{<path d="M9 21h6v-1H9v1zm3-20C7.93 1 5 3.93 5 7c0 2.38 1.19 4.47 3 5.74V15c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.07-2.93-6-7-6zm2.3 10.05-.3.2V15h-4v-3.75l-.3-.2A4.97 4.97 0 0 1 7 7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.7 4.05z"/>}
);

swap_icon_after_title('Shareholder Agreements',
  q{<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>}
);

swap_icon_after_title('Startup Legals',
  q{<path d="M12 2c-2.76 0-5 2.24-5 5v1.5L5 10v2l2-.5V13c0 2.76 2.24 5 5 5s5-2.24 5-5v-1.5l2 .5v-2l-2-1.5V7c0-2.76-2.24-5-5-5zm0 2c1.65 0 3 1.35 3 3v1.08l-3 1.5-3-1.5V7c0-1.65 1.35-3 3-3zm0 12c-1.65 0-3-1.35-3-3v-1.08l3 1.5 3-1.5V13c0 1.65-1.35 3-3 3z"/>}
);

swap_icon_after_title('Fractional General Counsel',
  q{<path d="M10 4h4v2h-4V4zm-2 0a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v3h-7v-1H9v1H2V8a2 2 0 0 1 2-2h2V4zm14 7v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9h7v1h6v-1h7z"/>}
);

swap_icon_after_title('Referrals',
  q{<path d="M3.9 12a5 5 0 0 1 5-5h3v2h-3a3 3 0 0 0 0 6h3v2h-3a5 5 0 0 1-5-5zm7.1 1h2v-2h-2v2zm4-6h-3V7h3a5 5 0 0 1 0 10h-3v-2h3a3 3 0 0 0 0-6z"/>}
);

open my $out, '>', $file or die "Write $file: $!";
print $out $s;
close $out;

print "Patched icons in $file\n";
