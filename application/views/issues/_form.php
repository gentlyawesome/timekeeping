<p>
  <label for="issue_comment">Comment</label><br />
  <textarea  id="comment" name="issue_comment" class="form-control" ><?= isset($issues->comment) ? $issues->comment : '' ?></textarea>
</p>
<p>
  <label for="resolved">Resolved</label><br />
  <input id="issue_resolved_yes" name="issue_resolved" type="radio" value="<?= isset($issues->resolved) ? $issues->resolved : '' ?>" />Yes
  <input id="issue_resolved_no" name="issue_resolved" type="radio" value="<?= isset($issues->resolved) ? $issues->resolved : '' ?>" />No
</p>
