<?php

require(__DIR__ . "/../models/Category.php");
require(__DIR__ . "/../services/CategoryService.php");
require(__DIR__ . "/../controllers/BaseController.php");

class CategoryController extends BaseController {
    public function __construct() {
        parent::__construct();
    }

    public function getCategory($id) {
        try {
            $category = Category::find($this->mysqli, $id);
            if (!$category) {
                echo ResponseService::error_response("Category not found", 404);
                return;
            }
            echo ResponseService::success_response($category->toArray());
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function getAllCategories() {
        try {
            if (!isset($_GET["id"])) {
                $categories = Category::all($this->mysqli);
                $categories_array = CategoryService::categoriesToArray($categories); 
                echo ResponseService::success_response($categories_array);
                return;
            }

            $id = $_GET["id"];
            $category = Category::find($this->mysqli, $id)->toArray();
            echo ResponseService::success_response($category);
            return;
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function addCategory() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['name']) || empty($data['name'])) {
                echo ResponseService::error_response("Name is required", 400);
                return;
            }
            $category = new Category($this->mysqli);
            $category->name = $this->mysqli->real_escape_string($data['name']);
            $category->save();
            echo ResponseService::success_response($category->toArray(), 201);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function updateCategory($id) {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $category = Category::find($this->mysqli, $id);
            if (!$category) {
                echo ResponseService::error_response("Category not found", 404);
                return;
            }
            if (isset($data['name'])) $category->name = $this->mysqli->real_escape_string($data['name']);
            $category->save();
            echo ResponseService::success_response($category->toArray());
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function deleteCategory($id) {
        try {
            $category = Category::find($this->mysqli, $id);
            if (!$category) {
                echo ResponseService::error_response("Category not found", 404);
                return;
            }
            $category->delete();
            echo ResponseService::success_response(["message" => "Category deleted"]);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    public function deleteAllCategories() {
        try {
            $query = "DELETE FROM categories";
            if ($this->mysqli->query($query)) {
                echo ResponseService::success_response(["message" => "All categories deleted"]);
            } else {
                echo ResponseService::error_response("Failed to delete all categories", 500);
            }
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}