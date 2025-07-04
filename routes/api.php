<?php

require(__DIR__ . "/../controllers/ArticleController.php");
require(__DIR__ . "/../controllers/CategoryController.php");

$articleController = new ArticleController();
$categoryController = new CategoryController();

//For articles.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) && $_SERVER['REQUEST_URI'] === '/api/articles') {
        echo $articleController->getAllArticles();
    } elseif (isset($_GET['id']) && preg_match('#/api/articles\?id=(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
        echo $articleController->getArticle($matches[1]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/articles') {
    echo $articleController->addArticle();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('#/api/articles/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $articleController->updateArticle($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#/api/articles/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $articleController->deleteArticle($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $_SERVER['REQUEST_URI'] === '/api/articles') {
    echo $articleController->deleteAllArticles();
}

//For categories.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id']) && $_SERVER['REQUEST_URI'] === '/api/categories') {
        echo $categoryController->getAllCategories();
    } elseif (isset($_GET['id']) && preg_match('#/api/categories\?id=(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
        echo $categoryController->getCategory($matches[1]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/categories') {
    echo $categoryController->addCategory();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT' && preg_match('#/api/categories/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $categoryController->updateCategory($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && preg_match('#/api/categories/(\d+)#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $categoryController->deleteCategory($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $_SERVER['REQUEST_URI'] === '/api/categories') {
    echo $categoryController->deleteAllCategories();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/api/articles/category/(\d+)$#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $articleController->getArticlesByCategoryId($matches[1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/api/articles/(\d+)/category$#', $_SERVER['REQUEST_URI'], $matches)) {
    echo $articleController->getCategoryOfArticle($matches[1]);
}