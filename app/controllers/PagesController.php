<?php

namespace app\controllers;

session_start();

use app\models\CategoryModel;
use app\models\ObjectModel;
use app\models\UserModel;
use flight\Engine;

class PagesController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function login()
	{
		$data = $this->app->request()->data;
		if (empty($data['username']) || empty($data['password'])) {
			$this->app->render('login');
			return;
		}
		$user = new UserModel();
		if ($user->login($data['username'], $data['password'])) {
			$this->app->redirect(BASE_URL . '/products/lists');
		} else {
			$this->app->render('login', ['error' => 'Invalid username or password']);
		}
	}
	public function logout()
	{
		$user = new UserModel();
		$user->logout();
		$this->app->redirect(BASE_URL . '/');
	}

	public function addCategory()
	{
		$data = $this->app->request()->data;
		if (empty($data['nom']) || empty($data['description'])) {
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

	public function deleteCategory($id)
	{
		$categorie = new CategoryModel();
		$categorie->setId($id);
		$categorie->deleteCategory();
		$this->app->redirect(BASE_URL . '/category/lists');
	}
	public function updateCategoryForm($id)
	{
		$categorie = new CategoryModel();
		$categorie->setId($id);
		$category = $categorie->getCategorieById(id: $id);
		$this->app->render('updateCategoryForm', ['categorie' => $category]);
	}

	public function updateCategory()
	{
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
	public function toLists()
	{
		$categorie = new CategoryModel();
		$categories = $categorie->getAllCategories();
		$this->app->render('lists', ['categories' => $categories]);
	}
	public function products()
	{
		$products = new ObjectModel();
		$objects = $products->getAllObjects($_SESSION['user_id']);
		$name = new UserModel();
		foreach ($objects as $key => $object) {
			$objects[$key]['username'] = $name->getUserNameById($object['user_id']);
		}
		$this->app->render('model', ['objects' => $objects, 'page' => 'productsLists']);
	}

	public function showMyProductsExchange()
	{
		$data = $this->app->request()->data;
		$otherObjectId = $data['id'];
		$products = new ObjectModel();
		$objects = $products->getObjectsByUserId($_SESSION['user_id']);
		$name = new UserModel();
		foreach ($objects as $key => $object) {
			$objects[$key]['username'] = $name->getUserNameById($object['user_id']);
		}
		$this->app->render('model', ['objects' => $objects, 'otherObjectId' => $otherObjectId, 'page' => 'myProductsLists']);
	}
	public function categories()
	{
		$categorie = new CategoryModel();
		$categories = $categorie->getAllCategories();
		$this->app->render('model', ['categories' => $categories, 'page' => 'categoriesLists']);
	}
	public function myProducts(){
		$products = new ObjectModel();
		$objects = $products->getObjectsByUserId($_SESSION['user_id']);
		$name = new UserModel();
		foreach ($objects as $key => $object) {
			$objects[$key]['username'] = $name->getUserNameById($object['user_id']);
		}
		// Vérifier si c'est une requête AJAX
		if (
			!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
		) {

			// Retourner en JSON pour les requêtes AJAX
			header('Content-Type: application/json');
			echo json_encode([
				'success' => true,
				'objects' => $objects
			]);
			exit;
		}

		// Sinon, afficher la vue normale
		$this->app->render('model', [
			'objects' => $objects,
			'page' => 'myProductsLists'
		]);
	}

}
