<?php

namespace App\Http\Controllers;

use App\Stores;
use http\Exception;
use Illuminate\Http\Request;

class StoresController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        return response()->json(Stores::get(), 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id) {
        try {
            $stores = Stores::findOrFail($id);
            if (is_null($stores)) {
                return response()->json([], 404);
            }
            $response =  response()->json($stores);
        } catch (Exception $ex) {
            $response =  response()->json($ex->getMessage());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        try {
            $store = Stores::create($request->all());
            $response =  response()->json($store);
        } catch (Exception $ex) {
            $response =  response()->json($ex->getMessage());
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        try {
            $store = Stores::findOrFail($id);
            $store->update($request->all());
            $response =  response()->json($store);
        } catch (Exception $ex) {
            $response =  response()->json($ex->getMessage());
        }

		return $response;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        try {
            Stores::find($id)->delete();
            $response =  response()->json([], 204);
        } catch (Exception $ex) {
            $response =  response()->json($ex->getMessage());
        }

		return $response;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show_products($id) {
        try {
            $stores = Stores::findOrFail($id);
            if (is_null($stores)) {
                return response()->json([], 404);
            } else {
                $storeResponse = json_decode($stores, true);
                $storeName = $storeResponse['platform'];
                $data = file_get_contents("../resources/json/{$storeName}/products.json");
                $productDetails = json_decode($data, true);

                $getStore = new Stores();
                $response = $getStore->$storeName($productDetails);
            }

        } catch (Exception $ex) {
            $response =  response()->json($ex->getMessage());
        }

       return $response;
    }
}
