<?php

/**
 * Redirects user to given page
 *
 * @param string $page - path to given page
 * @return void
 */
function redirect_to(string $page)
{
    header("Location: $page", true, 303);
    exit();
}

/**
 * Builds path from array based on the OS
 *
 * @param array $segments
 * @return string
 */
function file_build_path($segments)
{
    return implode(DIRECTORY_SEPARATOR, $segments);
}

/**
 * Uploads file to a given directory.
 * Generates unique name, and returns the path where the file is located
 *
 * @param array $uploaded_file
 * @param string $to_dir;
 *
 * @return string
 */
function save_uploaded_file($uploaded_file, $to_dir = 'storage')
{
    $extension = strtolower(pathinfo(basename($uploaded_file["name"]), PATHINFO_EXTENSION));

    $target_path  = file_build_path([$to_dir, md5(rand(0, 9999999999999)) . '.' . $extension]);

    move_uploaded_file($uploaded_file["tmp_name"], file_build_path([$_SERVER['DOCUMENT_ROOT'], $target_path]));

    return file_build_path(['', $target_path]);
}

/**
 * Transforms the original super global variable $_FILES to more managable version
 *
 * @param array $files
 * @return array
 */
function transform_multiple_files($files)
{
    $result = [];
    if (empty($files) || (isset($files['name'][0]) && empty($files['name'][0]))) return $result;
    $file_count = count($files['name']);

    for ($index = 0; $index  < $file_count; $index++) {
        $file = [];
        foreach ($files as $key => $value) {
            $file[$key] = $value[$index];
        }
        $result[] = $file;
    }
    return $result;
}

/**
 * Generates HTML for the pagination compoment.
 *
 * @param int $maxPage
 * @param int $page
 *
 * @return string
 */
function render_pagination($maxPage, $page)
{
    if ($maxPage <= 1) {
        return '';
    }
    $items = [];
    $getParams = $_GET;

    for ($i = 1; $i <= $maxPage; $i++) {
        $active = $i == $page ? 'active' : '';
        $getParams['page'] = $i;
        $link = http_build_query($getParams);
        $items[] = '<li class="page-item ' . $active . '"><a class="page-link" href="?' . $link . '">' . $i . '</a></li>';
    }
    $finalItems = implode('', $items);
    $getParams['page'] = max($page - 1, 1);
    $prevLink =  http_build_query($getParams);
    $getParams['page'] =  min($page + 1, $maxPage);
    $nextLink =  http_build_query($getParams);

    $component = '<div class="row">';
    $component .= '<div class="col-sm-12">';
    $component .= '<nav class="pagination-a">';
    $component .= '<ul class="pagination justify-content-end">';
    $component .= '<li class="page-item"><a class="page-link" href="?' . $prevLink . '"><span class="bi bi-chevron-left"></span> </a></li>';
    $component .= $finalItems;
    $component .= '<li class="page-item "><a class="page-link" href="?' . $nextLink . '"><span class="bi bi-chevron-right"></span></a></li>';
    $component .= '</ul>';
    $component .= '</nav>';
    $component .= '</div>';
    $component .= '</div>';
    return $component;
}
