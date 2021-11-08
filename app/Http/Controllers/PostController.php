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
							$image = '<img src="' . $image_url . '" width="30%">';
						}
						return $image;
					})
					->addColumn('action', function ($row) {
						$btn = '';
						$btn = '<a href="' . url('admin/posts/' . $row->id . '/edit') . '" class="edit_icon mr-1" title="Edit">
                        <i class="fas fa-edit icon_color" ></i> </a>';
						$btn = $btn . '<a onclick=deletesingle("' . $row->id . '","control-panel/manage-product","posts_table") title="Delete" class="trash_icon"><i class="fas fa-trash-alt icon_color" ></i> </a>';
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
}
