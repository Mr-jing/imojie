<?php

namespace Imojie\Http\ApiControllers;

use Illuminate\Support\Facades\Gate;
use Imojie\Models\Reply;
use Imojie\Models\Topic;
use Imojie\Http\Requests\SaveReplyRequest;
use Imojie\Transformers\ReplyTransformer;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\DeleteResourceFailedException;
use HyperDown\Parser;

class ReplyController extends Controller
{
    public function __construct()
    {
    }


    public function store(SaveReplyRequest $request)
    {
        $user = app('Dingo\Api\Auth\Auth')->user();
        $topic = Topic::findOrFail($request->input('topic_id'));
        $originalContent = trim($request->input('reply_content'));

        $data = array(
            'user_id' => $user->id,
            'topic_id' => $topic->id,
            'original_content' => $originalContent,
            'content' => (new Parser)->makeHtml($originalContent),
        );

        $reply = Reply::create($data);
        if ($reply) {
            return $this->response()->item($reply, new ReplyTransformer());
        } else {
            throw new StoreResourceFailedException('保存失败，请重新尝试');
        }
    }


    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $user = app('Dingo\Api\Auth\Auth')->user();

        if (Gate::forUser($user)->denies('delete-reply', $reply)) {
            throw new AccessDeniedHttpException();
        }

        if ($reply->delete()) {
            return $this->response()->item($reply, new ReplyTransformer());
        } else {
            throw new DeleteResourceFailedException('删除失败，请重新尝试');
        }
    }

}
