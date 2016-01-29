<?php

namespace Imojie\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Imojie\Models\Topic;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Imojie\Http\Requests\SaveTopicRequest;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        \DB::connection()->enableQueryLog();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'active');

        switch ($sort) {
            case 'active':
                $topics = Topic::active()->paginate(5);
                break;
            case 'excellent':
                $topics = Topic::excellent()->paginate(5);
                break;
            case 'hot':
                $topics = Topic::hot()->paginate(5);
                break;
            case 'newest':
                $topics = Topic::newest()->paginate(5);
                break;
            default:
                $sort = 'active';
                $topics = Topic::active()->paginate(5);
                break;
        }

//        dd(\DB::getQueryLog());

        return view('topic.index', compact('topics', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('topic.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $topic = Topic::findOrFail($id);
        $replies = $topic->replies()->paginate(1);

        return view('topic.show', compact('topic', 'replies'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $topic = Topic::findOrFail($id);
        return view('topic.edit', compact('topic'));
    }


}
