<?php

namespace app\controllers;
use app\models\CategoryModel;
use app\models\ObjectModel;
use app\models\UserModel;
use flight\Engine;

class PagesController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function addCategory() {
		$data = $this->app->request()->data;
		if(empty($data['nom']) || empty($data['description'])) {
			$this->app->render('addCategoryForm');
			return;
		}
		$categorie = new CategoryModel();
		$data = $this->app->request()->data;
		$categorie->setName($data['nom']);
		$categorie->setDescription($data['description']);
		$categorie->addCategory();
		$this->app->redirect(BASE_URL . '/category/lists');
	}

	public function deleteCategory($id) {
		$categorie = new CategoryModel();
		$categorie->setId($id);
		$categorie->deleteCategory();
		$this->app->redirect(BASE_URL . '/category/lists');
	}
	public function updateCategoryForm($id) {
		$categorie = new CategoryModel();
		$categorie->setId($id);
		$category = $categorie->getCategorieById(id: $id);
		$this->app->render('updateCategoryForm', [ 'categorie' => $category ]);
	}

	public function updateCategory() {
		$data = $this->app->request()->data;
		$id = $data['id'];
        $name = $data['name'];
        $description = $data['description'];
        $status = $data['status'];

		$categorie = new CategoryModel();
        $categorie->setId($id);
        $categorie->setName($name);
        $categorie->setDescription($description);
        $categorie->setStatus($status);
		$categorie->updateCategory();
		$this->app->redirect(BASE_URL . '/category/lists');
	}
	public function toLists() {
		$categorie = new CategoryModel();
		$categories = $categorie->getAllCategories();
		$this->app->render('lists', [ 'categories' => $categories ]);
	}
	public function products() {
		$products = new ObjectModel();
		$objects = $products->getAllObjects();
		$name = new UserModel();
		foreach ($objects as $key => $object) {
			$objects[$key]['username'] = $name->getUserNameById($object['user_id']);
		}
		$this->app->render('model', [ 'objects' => $objects, 'page' => 'productsLists' ]);
	}

	public function exchange() {
		
		$this->app->render('exchange');
	}
	public function categories() {
		$categorie = new CategoryModel();
		$categories = $categorie->getAllCategories();
		$this->app->render('model', [ 'categories' => $categories, 'page' => 'categories' ]);
	}

	// public function getUsers() {
	// 	// You could actually pull data from the database if you had one set up
	// 	// $users = $this->app->db()->fetchAll("SELECT * FROM users");
	// 	$users = [
	// 		[ 'id' => 1, 'name' => 'Bob Jones', 'email' => 'bob@example.com' ],
	// 		[ 'id' => 2, 'name' => 'Bob Smith', 'email' => 'bsmith@example.com' ],
	// 		[ 'id' => 3, 'name' => 'Suzy Johnson', 'email' => 'suzy@example.com' ],
	// 	];

	// 	// You actually could overwrite the json() method if you just wanted to
	// 	// to ->json($users); and it would auto set pretty print for you.
	// 	// https://flightphp.com/learn#overriding
	// 	$this->app->json($users, 200, true, 'utf-8', JSON_PRETTY_PRINT);
	// }

}