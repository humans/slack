import Echo from 'laravel-echo';

// Let's prefix everyhting with the team name.
class Holler extends Echo {
  private (key) {
    return super.private(window.Slack.team + '.' + key);
  }

  leave (key) {
    return super.leave(window.Slack.team + '.' + key);
  }
}

export default Holler;
