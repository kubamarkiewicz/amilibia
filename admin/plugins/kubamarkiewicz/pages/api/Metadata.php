<?php namespace KubaMarkiewicz\Pages\Api;

use Illuminate\Routing\Controller;
use KubaMarkiewicz\Pages\Models\Page;

class Metadata extends Controller
{

    public function index($url = 'home', $locale = 'es')
    {
        // echo $url;
        // echo "<pre>";
        // print_r($_SERVER);

        $query = Page::where('slug', $url)->with('meta_image');
        $page = $query->first(); 

        if ($page) : ?>
<!doctype html>
<html>
<head>
    <title><?=e($page->meta_title ? $page->meta_title : $page->name) ?></title>
    <meta name="description" content="<?=e($page->meta_description)?>">
    <meta property="og:url"           content="<?=$page->fullUrl?>">
    <meta property="og:type"          content="website">
    <meta property="og:title"         content="<?=e($page->meta_title ? $page->meta_title : $page->name) ?>">
    <meta property="og:description"   content="<?=e($page->meta_description)?>">
    <?php if($page->meta_image) : ?>
        <meta property="og:image"         content="<?=$page->meta_image->getPath()?>">
    <?php endif ?>
</head>
<body></body>
</html>
        <?php else : ?>

        Page not found: <?=$url?>

        <?php endif;
    }


}