import Echo from 'laravel-echo';

class Holler extends Echo {
  private (channel) {
    return super.private(window.Slack.team + '.channel.' + channel);
  }

  leave (channel) {
    return super.leave(window.Slack.team + '.channel.' + channel);
  }
}

export default Holler;
