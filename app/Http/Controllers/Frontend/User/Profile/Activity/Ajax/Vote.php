<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\VoteRequest;
use App\Models\ArticleComment;
use App\Models\ArticleCommentVote;
use App\Models\ArticleReply;
use App\Models\ArticleReplyVote;
use App\Models\GeneralAnswer;
use App\Models\GeneralAnswerVote;
use App\Models\GeneralQuestion;
use App\Models\GeneralQuestionVote;
use App\Models\RecipeAnswer;
use App\Models\RecipeQuestion;
use App\Models\Review;
use App\Models\ReviewComment;
use App\Models\ReviewVote;
use App\Models\ReviewCommentVote;
use App\Models\RecipeQuestionVote;
use App\Models\RecipeAnswerVote;
use App\Enums\CommunityType;

class Vote extends AbstractProfile
{
    /**
     * @var
     */
    protected $type;

    /**
     * @var
     */
    protected $id;

    /**
     * @param VoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(VoteRequest $request)
    {
        $this->type = $request->get('type');
        $this->id   = $request->get('id');

        switch ($this->type) {
            case CommunityType::ARTICLE_COMMENT:
                $votes = $this->voteArticleComment();
                break;
            case CommunityType::ARTICLE_REPLY:
                $votes = $this->voteArticleReply();
                break;
            case CommunityType::GENERAL_QUESTION:
                $votes = $this->voteGeneralQuestion();
                break;
            case CommunityType::GENERAL_ANSWER:
                $votes = $this->voteGeneralAnswer();
                break;
            case CommunityType::RECIPE_REVIEW:
                $votes = $this->voteRecipeReview();
                break;
            case CommunityType::REVIEW_COMMENT:
                $votes = $this->voteReviewComment();
                break;
            case CommunityType::RECIPE_ANSWER:
                $votes = $this->voteRecipeAnswer();
                break;
            case CommunityType::RECIPE_QUESTION:
            default:
                $votes = $this->voteRecipeQuestion();
                break;
        }

        $data = [];
        $data['message'] = trans('user/profile.ajax_messages.voted');
        $data['content'] = view('community.json_blocks.vote', [
            'votes' => $votes
        ])->render();

        return response()->json($data);
    }

    /**
     * Vote article comment
     */
    protected function voteArticleComment()
    {
        $voted = ArticleCommentVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new ArticleCommentVote();
            $vote->article_comment_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $comment = ArticleComment::find($this->id);

        return $comment->votes;
    }

    /**
     * Vote article reply
     */
    protected function voteArticleReply()
    {
        $voted = ArticleReplyVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new ArticleReplyVote();
            $vote->article_reply_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $reply = ArticleReply::find($this->id);

        return $reply->votes;
    }

    /**
     * Vote general question
     */
    protected function voteGeneralQuestion()
    {
        $voted = GeneralQuestionVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new GeneralQuestionVote();
            $vote->question_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $question = GeneralQuestion::find($this->id);

        return $question->votes;
    }

    /**
     * Vote general answer
     */
    protected function voteGeneralAnswer()
    {
        $voted = GeneralAnswerVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new GeneralAnswerVote();
            $vote->answer_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $answer = GeneralAnswer::find($this->id);

        return $answer->votes;
    }

    /**
     * Vote recipe review
     */
    protected function voteRecipeReview()
    {
        $voted = ReviewVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new ReviewVote();
            $vote->review_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $review = Review::find($this->id);

        return $review->votes;
    }


    /**
     * Vote recipe question
     */
    protected function voteRecipeQuestion()
    {
        $voted = RecipeQuestionVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new RecipeQuestionVote();
            $vote->recipe_question_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $question = RecipeQuestion::find($this->id);

        return $question->votes;
    }

    /**
     * Vote review comment
     */
    protected function voteReviewComment()
    {
        $voted = ReviewCommentVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new ReviewCommentVote();
            $vote->review_comment_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $comment = ReviewComment::find($this->id);

        return $comment->votes;
    }

    /**
     * Vote recipe answer
     */
    protected function voteRecipeAnswer()
    {
        $voted = RecipeAnswerVote::voted($this->currentUser->id, $this->id)->count();

        if (!$voted) {
            $vote = new ReviewCommentVote();
            $vote->review_comment_id = $this->id;
            $vote->user_id = $this->currentUser->id;
            $vote->save();
        }

        $answer = RecipeAnswer::find($this->id);

        return $answer->votes;
    }
}
