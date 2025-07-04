<?php 

require(__DIR__ . "/../models/Article.php");
require(__DIR__ . "/../connection/connection.php");
require(__DIR__ . "/../services/ArticleService.php");
require(__DIR__ . "/../services/ResponseService.php");

class ArticleController{
    
    public function getArticle($id) {
        global $mysqli;
        try {
            $article = Article::find($mysqli, $id);
            if (!$article) {
                echo ResponseService::error_response("Article not found", 404);
                return;
            }
            echo ResponseService::success_response($article->toArray());
        } catch (Exception $e) {
            echo ResponseService::error_response("Failed to fetch article: " . $e->getMessage(), 500);
        }
    }

    public function getAllArticles(){
        global $mysqli;

        if(!isset($_GET["id"])){
            $articles = Article::all($mysqli);
            $articles_array = ArticleService::articlesToArray($articles);
            echo ResponseService::success_response($articles_array);
            return;
        }

        $id = $_GET["id"];
        $article = Article::find($mysqli, $id)->toArray();
        echo ResponseService::success_response($article);
        return;
    }

    public function addArticle() {
        global $mysqli;
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['name']) || !isset($data['author']) || !isset($data['description']) || 
                empty($data['name']) || empty($data['author']) || empty($data['description'])) {
                echo ResponseService::error_response("Name, author, and description are required", 400);
                return;
            }
            $article = new Article($mysqli);
            $article->name = $mysqli->real_escape_string($data['name']);
            $article->author = $mysqli->real_escape_string($data['author']);
            $article->description = $mysqli->real_escape_string($data['description']);
            $article->save();
            echo ResponseService::success_response($article->toArray(), 201);
        } catch (Exception $e) {
            echo ResponseService::error_response("Failed to add article: " . $e->getMessage(), 500);
        }
    }

    public function updateArticle($id) {
        global $mysqli;
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $article = Article::find($mysqli, $id);
            if (!$article) {
                echo ResponseService::error_response("Article not found", 404);
                return;
            }
            if (isset($data['name'])) $article->name = $mysqli->real_escape_string($data['name']);
            if (isset($data['author'])) $article->author = $mysqli->real_escape_string($data['author']);
            if (isset($data['description'])) $article->description = $mysqli->real_escape_string($data['description']);
            $article->save();
            echo ResponseService::success_response($article->toArray());
        } catch (Exception $e) {
            echo ResponseService::error_response("Failed to update article: " . $e->getMessage(), 500);
        }
    }

    public function deleteArticle($id) {
        global $mysqli;
        try {
            $article = Article::find($mysqli, $id);
            if (!$article) {
                echo ResponseService::error_response("Article not found", 404);
                return;
            }
            $article->delete();
            echo ResponseService::success_response(["message" => "Article deleted"]);
        } catch (Exception $e) {
            echo ResponseService::error_response("Failed to delete article: " . $e->getMessage(), 500);
        }
    }

    public function deleteAllArticles(){
        die("Deleting...");
    }
}

//To-Do:
 
//2- Find a way to remove the hard coded response code (from ResponseService.php)
//3- Include the routes file (api.php) in the (index.php) -- In other words, seperate the routing from the index (which is the engine)