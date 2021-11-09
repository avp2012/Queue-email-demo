<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Datatables;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller {
	public function index(Request $request) {
		try {
			if ($request->ajax()) {
				$posts = Post::latest()->get();
				return Datatables::of($posts)
					->addIndexColumn()
					->addColumn('check', function ($row) {
						$check = '<label class="container_chk"> <input type="checkbox" value="' . $row->id . '"><span class="checkmark"></span></label>';
						return $check;
					})
					->addColumn('title', function ($row) {
						$title = ucfirst($row->title);
						return $title;
					})
					->addColumn('category', function ($row) {
						$category = ucfirst($row->category);
						return $category;
					})
					->addColumn('image', function ($row) {
						$image = '';
						$image_url = asset('backend/images/posts/' . $row->image);
						if ($row->image != null) {
							$image = '<img src="' . $image_url . '" style="width: 50px;">';
						}
						return $image;
					})
					->addColumn('action', function ($row) {
						$btn = '';
						$btn = '<a href="' . url('admin/posts/' . $row->id . '/edit') . '" class="edit_icon mr-1" title="Edit">
                        <i class="fas fa-edit icon_color" ></i> </a>';
						$btn = $btn . '<a onclick=deletesingle("' . $row->id . '","posts","posts_table") title="Delete" class="trash-icon"><i class="fas fa-trash-alt icon_color" ></i> </a>';
						return $btn;
					})
					->rawColumns(['action', 'check', 'category', 'title', 'image'])
					->make(true);
			}
			return view('backend.posts.index');
		} catch (Exception $e) {
			return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
		}
	}

	public function create() {
		try {
			return view('backend.posts.create');
		} catch (Exception $e) {
			return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
		}
	}

	public function store(Request $request) {
		try {
			$validator = \Validator::make($request->all(), [
				'title' => 'required|min:2|max:255',
				'category' => 'required',
				'content' => 'required|min:2',
			]);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$input = $request->except(['_token']);
			if ($request->file('image')) {
				$imageName = time() . '.' . $request->image->extension();
				$request->image->move(public_path('backend/images/posts/'), $imageName);
				$input['image'] = $imageName;
			}
			$insert = Post::create($input);
			if ($insert) {
				return redirect()->route('posts.index')->with(['message.content' => 'Post added successfully.', 'message.level' => 'success']);
			} else {
				return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
			}
		} catch (Exception $e) {
			return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
		}
	}

	public function edit($id) {
		try {
			$post = Post::find($id);
			if ($post) {
				return view('backend.posts.edit', compact('post'));
			} else {
				return redirect()->route('posts.index')->with(['message.content' => 'Post not found.', 'message.level' => 'danger']);
			}
		} catch (Exception $e) {
			return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
		}
	}

	public function update(Request $request, $id) {
		try {
			$validator = \Validator::make($request->all(), [
				'title' => 'required|min:2|max:255',
				'category' => 'required',
				'content' => 'required|min:2',
			]);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			$posts = Post::find($id);
			$input = $request->except(['_method', '_token']);
			if ($request->has('post_img')) {
				if ($request->post_img == null) {
					$image_path = public_path('backend/images/posts/' . $posts->image);
					if (file_exists($image_path)) {
						unlink($image_path);
					}
					$input['image'] = null;
				}
			}

			if ($request->file('image')) {
				$imageName = time() . '.' . $request->image->extension();
				$request->image->move(public_path('backend/images/posts/'), $imageName);
				$input['image'] = $imageName;
			}
			$insert = $posts->update($input);
			if ($insert) {
				return redirect()->route('posts.index')->with(['message.content' => 'Post updated successfully.', 'message.level' => 'success']);
			} else {
				return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
			}
		} catch (Exception $e) {
			return redirect()->route('posts.index')->with(['message.content' => 'Something went wrong, try again later.', 'message.level' => 'danger']);
		}
	}

	public function destroy($id) {
		try {
			$post = Post::find($id);
			if ($post) {
				Post::where('id', $id)->delete();
				$response = array('data' => null, 'status' => 1, 'responseMessage' => "Post deleted successfully.");
			} else {
				$response = array('data' => null, 'status' => 0, 'responseMessage' => "Post Not found!!.");
			}
			return response()->json($response)->setStatusCode(200);
		} catch (Exception $e) {
			$response = array('data' => null, 'status' => 0, 'responseMessage' => "Something went wrong, try again later.");
			return response()->json($response)->setStatusCode(400);
		}
	}

	public function multiplePostsDelete(Request $request) {
		try {
			$post = Post::whereIn('id', $request->ids)->get();
			if (count($post) > 0) {
				Post::whereIn('id', $request->ids)->delete();
				$response = array('data' => null, 'status' => 1, 'responseMessage' => "Post Deleted successfully.");
			} else {
				$response = array('data' => null, 'status' => 0, 'responseMessage' => "Post Not found!!.");
			}
			return response()->json($response)->setStatusCode(200);
		} catch (Exception $e) {
			$response = array('data' => null, 'status' => 0, 'responseMessage' => "Something went wrong, try again later.");
			return response()->json($response)->setStatusCode(400);
		}
	}
}
