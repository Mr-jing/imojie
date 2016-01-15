<?php

namespace Imojie\Http\ApiControllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Imojie\Models\Topic;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Imojie\Http\Requests\SaveTopicRequest;
use Imojie\Transformers\TopicTransformer;

class TopicController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    public function index()
    {
        $topics = Topic::all();

        return $this->response()->collection($topics, new TopicTransformer());
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
        if ($topic && isset($topic->id)) {
            return new JsonResponse(['message' => '发贴成功', 'data' => $topic->id], 200);
        } else {
            return new JsonResponse('保存失败，请重新尝试', 500);
        }
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
            return new JsonResponse('修改成功', 200);
        } else {
            return new JsonResponse('修改失败，请重新尝试', 500);
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

        $user = app('Dingo\Api\Auth\Auth')->user();

        if (Gate::forUser($user)->denies('delete-topic', $topic)) {
            throw new AccessDeniedHttpException();
        }

        if ($topic->delete()) {
            return new JsonResponse('删除成功', 200);
        } else {
            return new JsonResponse('删除失败，请重新尝试', 500);
        }
    }

}
