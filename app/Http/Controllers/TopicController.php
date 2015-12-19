<?php

namespace Imojie\Http\Controllers;

use Illuminate\Http\Request;

use Imojie\Http\Requests;
use Imojie\Models\Topic;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Imojie\Http\Requests\SaveTopicRequest;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $topics = Topic::get();
        return view('topic.index', compact('topics'));
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
        $data = array(
            'uid' => Sentinel::getUser()->id,
            'title' => $request->input('title'),
            'original_content' => $request->input('content'),
            'content' => $request->input('content'),
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

        $data = array(
            'title' => $request->input('title'),
            'original_content' => $request->input('content'),
            'content' => $request->input('content'),
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
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);


        if ($topic->uid !== Sentinel::getUser()->id) {
            throw new AccessDeniedHttpException();
        }

        if ($topic->delete()) {
            return redirect()->back()->with('message', '删除成功');
        } else {
            return redirect()->back()->withErrors(['删除失败，请重新尝试']);
        }
    }
}
