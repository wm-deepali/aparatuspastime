@php
  // empty / null values schema se hata deta hai
  $prune = function ($v) use (&$prune) {
    if (!is_array($v)) return $v;
    $isList = array_is_list($v);
    $v = array_filter(array_map($prune, $v), fn($x) => $x !== null && $x !== '' && $x !== []);
    return $isList ? array_values($v) : $v;
  };
  $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP;

  $ldBlocks = [];

  if (!empty($crumbs)) {
    $ldBlocks[] = [
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => collect($crumbs)->values()->map(fn($b, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $b['name'],
        'item' => $b['url'],
      ])->all(),
    ];
  }

  foreach (($schemas ?? []) as $s) {
    $ldBlocks[] = $s;
  }
@endphp
@foreach ($ldBlocks as $block)
<script type="application/ld+json">{!! json_encode($prune($block), $jsonFlags) !!}</script>
@endforeach