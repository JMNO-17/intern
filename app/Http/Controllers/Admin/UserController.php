<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\common;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public $userRepository;

    public $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = $this->userRepository->all();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->roleRepository->all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->store($request->all());

        return redirect()->route('admin.users.index')->with('success', __('global.created_success'));
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = $this->roleRepository->all();
        $user->load('roles');

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->except('roles');
        if (empty($data['password'])) {
            unset($data['password']);
        }
        $this->userRepository->update($data, $user);
        if (count($request->input('roles', [])) > 0) {
            $user->syncRoles($request->input('roles', []));
        }

        return redirect()->route('admin.users.index')->with('success', __('global.updated_success'));
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user->load('roles');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $this->userRepository->softdelete($user);

        return redirect()->back()->with('success', __('global.deleted_success'));
    }

    public function profile()
    {
        $user = auth()->user();

        return view('admin.users.profile', compact('user'));
    }

    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $user = auth()->user();
        if (empty($request['password'])) {
            unset($request['password']);
        }
        $this->userRepository->update($request->all(), $user);

        return redirect()->route('admin.profile')->with('success', __('global.updated_success'));
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('uploads/temp/user/'.Auth::id());
        $file = $request->file('file');
        $response = common::storeMedia($path, $file);

        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $user = User::find($request->user_id);
        $status = false;

        if ($type == 'profile_image') {
            $mediaItem = $user->getMedia('profile_image')->first();
            if ($mediaItem) {
                $mediaItem->delete();
                $status = true;
            }
        }

        return response()->json([
            'status' => $status,
            'type' => $type,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $activeCount = User::where('status', true)->count();
        if ($activeCount <= 1 && $request->status == 'false') {
            return response()->json(['error' => 'One User Must Be Active.'], 400);
        } else {
            $user = User::find($request->id);
            $user->status = $request->status == 'false' ? false : true;
            if ($request->status == false) {
                $user->save();
            } elseif ($request->status == true) {
                $user->save();
            }
            $user->save();
            return response()->json(['success' => 'Successfully change status.'], 200);
        }
    }
}
