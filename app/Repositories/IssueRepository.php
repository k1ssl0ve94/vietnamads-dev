<?php
namespace App\Repositories;
use App\Issue;
use App\IssueLog;
use Carbon\Carbon;

class IssueRepository
{
    public function findById($id)
    {
        return Issue::find($id);
    }

    public function add($data)
    {
        $issue = new Issue;

        $issue->priority      = $data["priority"];
        $issue->title         = $data["title"];
        $issue->created_email = $data["created_email"];
        $issue->product       = $data["product"];
        $issue->system        = $data["system"];
        $issue->source        = $data["source"];
        $issue->channel       = $data["channel"];
        $issue->type          = $data["type"];
        $issue->error_type    = $data["error_type"];
        $issue->assignee_id   = $data["assignee_id"];
        $issue->content       = $data["content"];
        $issue->reason        = $data["reason"];
        $issue->action        = $data["action"];
        $issue->comment       = $data["comment"];
        $issue->rating        = $data["rating"];
        $issue->tag           = $data['tag'];
        $issue->attachments   = isset($data['attachments']) ? $data['attachments'] : [];
        $issue->status        = $data['status'];
        $issue->code          = isset($data['code']) ? $data['code'] : '';

        if (!empty($data['deadline'])) {
            $issue->deadline = new Carbon($data['deadline']);
        }

        if (!empty($data['first_response_at'])) {
            $issue->first_response_at = new Carbon($data['first_response_at']);
        }

        if (!empty($data['buy_off_at'])) {
            $issue->buy_off_at = new Carbon($data['buy_off_at']);
        }

        if (!empty($data['close_at'])) {
            $issue->close_at = new Carbon($data['close_at']);
        }

        if (!empty($data['assign_at'])) {
            $issue->assign_at = new Carbon($data['assign_at']);
        }

        if ($issue->save()) {
            return $issue;
        }

        return null;
    }

    public function update($issue, $data)
    {
        $issue->priority      = $data["priority"];
        $issue->title         = $data["title"];
        $issue->created_email = $data["created_email"];
        $issue->product       = $data["product"];
        $issue->system        = $data["system"];
        $issue->source        = $data["source"];
        $issue->channel       = $data["channel"];
        $issue->type          = $data["type"];
        $issue->error_type    = $data["error_type"];
        $issue->assignee_id   = $data["assignee_id"];
        $issue->content       = $data["content"];
        $issue->reason        = $data["reason"];
        $issue->action        = $data["action"];
        $issue->comment       = $data["comment"];
        $issue->rating        = $data["rating"];
        $issue->tag           = $data['tag'];
        $issue->attachments   = isset($data['attachments']) ? $data['attachments']: [];
        $issue->code          = isset($data['code']) ? $data['code'] : '';

        if ($issue->status != config('issue.status.closed')) {
            $issue->status = $data['status'];
        }

        if ($data['status'] == config('issue.status.buy_off')) {
            $issue->done_at = Carbon::now();
        }

        if (!empty($data['deadline'])) {
            $issue->deadline = new Carbon($data['deadline']);
        }

        if (!empty($data['first_response_at'])) {
            $issue->first_response_at = new Carbon($data['first_response_at']);
        }

        if (!empty($data['buy_off_at'])) {
            $issue->buy_off_at = new Carbon($data['buy_off_at']);
        }

        if (!empty($data['close_at'])) {
            $issue->close_at = new Carbon($data['close_at']);
        }

        if (!empty($data['assign_at'])) {
            $issue->assign_at = new Carbon($data['assign_at']);
        }

        return $issue->save();

    }

    public function paginate($params = [], $with = [], $take = 20)
    {
        $query = $this->buildQuery($params, $with);

        return $query->paginate($take);
    }

    private function buildQuery($params = [], $with = [])
    {
        $query = Issue::query();

        if (!empty($params['keyword'])) {
            $query->where('id', $params['keyword'])
                ->orWhere('title', 'like', '%' . $params['keyword'] . '%')
                ->orWhere('created_email', 'like', '%' . $params['keyword'] . '%')
                ->orWhere('tag', 'like', '%' . $params['keyword'] . '%');
        }

        if (!empty($params['assignee_id']) && intval($params['assignee_id']) > 0) {
            $query->where('assignee_id', $params['assignee_id']);
        }

        if (!empty($params['source'])) {
            $query->whereHas('source', function ($query) use ($params) {
                $query->where('id', $params['source']);
            });
        }

        if (!empty($params['system'])) {
            $query->whereHas('system', function ($query) use ($params) {
                $query->where('id', $params['system']);
            });
        }

        if (!empty($params['product'])) {
            $query->whereHas('product', function ($query) use ($params) {
                $query->where('id', $params['product']);
            });
        }

        if (!empty($params['error_type'])) {
            $query->whereHas('errorType', function ($query) use ($params) {
                $query->where('id', $params['error_type']);
            });
        }

        if (!empty($params['issue_type'])) {
            $query->whereHas('type', function ($query) use ($params) {
                $query->where('id', $params['issue_type']);
            });
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($with)) {
            $query->with($with);
        }

        if (isset($params['order'])) {
            if ($params['order'] == 1) {
                $query->orderBy('id', 'desc');
            } else if ($params['order'] == 2) {
                $query->orderBy('id', 'asc');
            }
        }

        return $query;
    }

    public function getByOptions($params = [], $with = [])
    {
        $query = $this->buildQuery($params, $with);
        return $query->get();
    }

    public function delete($issue)
    {
        return $issue->delete();
    }

    public function count() {
        return Issue::count();
    }

    public function log($issueID, $status, $message, $username, $type = 0, $data = null)
    {
        $log = new IssueLog;

        $log->issue_id = $issueID;
        $log->status   = $status;
        $log->message  = $message;
        $log->type     = $type;
        $log->data     = '';

        if ($data) {
            $log->data = json_encode($data);
        }

        $log->username = $username;

        if ($log->save()) {
            return $log;
        }

        return null;
    }

    public function updateFeedback($issue, $rating, $comment)
    {
        $issue->rating = $rating;
        $issue->comment = $comment;
        $issue->status = config('issue.status.closed');
        $issue->close_at = Carbon::now();
        return $issue->save();
    }

    public function countByStatus($status, $from = null, $to = null)
    {
        $query = Issue::query();

        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->where('status', $status)->count();
    }

    public function countByRating($rating, $from = null, $to = null)
    {
        $query = Issue::query();

        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->where('rating', $rating)->count();
    }

    public function getLastIssues($take = 1)
    {
        return Issue::orderBy('id', 'desc')->take($take)->get();
    }

    public function getByCreatedRange($from = null, $to = null)
    {
        $query = Issue::query();

        if ($from) {
            $query->where('created_at', '>=', $from);
        }

        if ($to) {
            $query->where('created_at', '<=', $to);
        }

        return $query->orderBy('id', 'desc')->get();
    }
}