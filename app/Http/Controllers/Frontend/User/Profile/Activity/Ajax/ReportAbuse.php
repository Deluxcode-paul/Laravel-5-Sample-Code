<?php

namespace App\Http\Controllers\Frontend\User\Profile\Activity\Ajax;

use App\Http\Controllers\Frontend\User\Profile\AbstractProfile;
use App\Http\Requests\Frontend\User\Profile\Activity\ReportAbuseRequest;
use App\Models\ArticleCommentReport;
use App\Models\ArticleReplyReport;
use App\Models\GeneralAnswerReport;
use App\Models\GeneralQuestionReport;
use App\Models\ReviewReport;
use App\Models\ReviewCommentReport;
use App\Models\RecipeQuestionReport;
use App\Models\RecipeAnswerReport;
use App\Enums\CommunityType;

class ReportAbuse extends AbstractProfile
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
     * @param ReportAbuseRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(ReportAbuseRequest $request)
    {
        $this->type = $request->get('type');
        $this->id   = $request->get('id');

        switch ($this->type) {
            case CommunityType::ARTICLE_COMMENT:
                $this->reportArticleComment();
                break;
            case CommunityType::ARTICLE_REPLY:
                $this->reportArticleReply();
                break;
            case CommunityType::GENERAL_QUESTION:
                $this->reportGeneralQuestion();
                break;
            case CommunityType::GENERAL_ANSWER:
                $this->reportGeneralAnswer();
                break;
            case CommunityType::RECIPE_REVIEW:
                $this->reportRecipeReview();
                break;
            case CommunityType::REVIEW_COMMENT:
                $this->reportReviewComment();
                break;
            case CommunityType::RECIPE_ANSWER:
                $this->reportRecipeAnswer();
                break;
            case CommunityType::RECIPE_QUESTION:
            default:
                $this->reportRecipeQuestion();
                break;
        }

        $data = [];
        $data['message'] = trans('user/profile.ajax_messages.abused');
        $data['content'] = view('community.json_blocks.abuse')->render();

        return response()->json($data);
    }

    /**
     * Report article comment
     */
    protected function reportArticleComment()
    {
        $reported = ArticleCommentReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new ArticleCommentReport();
            $report->article_comment_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report article reply
     */
    protected function reportArticleReply()
    {
        $reported = ArticleReplyReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new ArticleReplyReport();
            $report->article_reply_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report general question
     */
    protected function reportGeneralQuestion()
    {
        $reported = GeneralQuestionReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new GeneralQuestionReport();
            $report->question_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report general answer
     */
    protected function reportGeneralAnswer()
    {
        $reported = GeneralAnswerReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new GeneralAnswerReport();
            $report->answer_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report recipe review
     */
    protected function reportRecipeReview()
    {
        $reported = ReviewReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new ReviewReport();
            $report->review_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }


    /**
     * Report recipe question
     */
    protected function reportRecipeQuestion()
    {
        $reported = RecipeQuestionReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new RecipeQuestionReport();
            $report->recipe_question_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report review comment
     */
    protected function reportReviewComment()
    {
        $reported = ReviewCommentReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new ReviewCommentReport();
            $report->review_comment_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }

    /**
     * Report recipe answer
     */
    protected function reportRecipeAnswer()
    {
        $reported = RecipeAnswerReport::reported($this->currentUser->id, $this->id)->count();

        if (!$reported) {
            $report = new ReviewCommentReport();
            $report->review_comment_id = $this->id;
            $report->user_id = $this->currentUser->id;
            $report->save();
        }
    }
}
