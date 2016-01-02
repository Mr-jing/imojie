<?php

namespace Imojie\Http\Controllers;

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
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(SaveTopicRequest $request)
    {
        $originalContent = trim($request->input('content'));
        $content = $originalContent;

        $data = array(
            'uid' => Sentinel::getUser()->id,
            'title' => trim($request->input('title')),
            'original_content' => $originalContent,
            'content' => $content,
            'active_at' => time(),
        );

        $topic = Topic::create($data);
        if ($topic->id) {
            return redirect()->route('topic.show', [$topic->id])->with('message', '发贴成功');
        } else {
            return redirect()->back()->withInput()->withErrors(['保存失败，请重新尝试']);
        }
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
        return view('topic.show', compact('topic'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(SaveTopicRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $originalContent = trim($request->input('content'));
        $content = $originalContent;

        $data = array(
            'title' => trim($request->input('title')),
            'original_content' => $originalContent,
            'content' => $content,
            'active_at' => time(),
        );

        if ($topic->update($data)) {
            return redirect()->route('topic.show', [$topic->id])->with('message', '修改成功');
        } else {
            return redirect()->back()->withInput()->withErrors(['修改失败，请重新尝试']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        if (Gate::forUser(Sentinel::getUser())->denies('delete-topic', $topic)) {
            throw new AccessDeniedHttpException();
        }

        if ($topic->delete()) {
            if ($request->ajax() || $request->wantsJson()) {
                return new JsonResponse('删除成功', 200);

            } else {
                return redirect()->route('topic.index')->with('message', '删除成功');
            }
        } else {
            return redirect()->back()->withErrors(['删除失败，请重新尝试']);
        }
    }
}
