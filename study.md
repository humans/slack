# Case Study: Developing Slack with Laravel & Vue

## Outline

- Overview
  - Why?
  - Features
  - Stack
  - Architecture
- Structuring Vue
  - Vuex, Vue Router
  - babel presets
  - ES6 issues with production.
  - Population via prop or HTTP request.
  - Rendering to a main component `AppView`
  - Global components versus prop components?
  - Passport & Laravel Defaults pitfalls
    Removing `window.Laravel` kinda breaks passport auth 'cause the CSRF token is looking for
    it when doing the validation.
  - Mulititenancy & Echo
  - broadcast()->toOthers() pitfalls
    That axios must be bound to the window for `toOthers` to work properly.
- Laravel
  - You trigger events where?!
  - __invoke is not the devil
  - Validation: Form Requests? Controller?
  - When and where to queue
  - Testing with events? Nay or Yay?
  - Count is pretty useful.
  - Model defaults
  - Many to Many to Many Polymorphic Relations
  - Route Model Binding
  - Triggerring events in events.
  - `appends` is your friend.
  - `display_name` works best for what we're using.
  - Deleting the default auth scaffolding (I really like restufl URLs)
- Architecture
  - Database Architecture
  - JAM Stack
  - Sometimes, it might be better to start off with complexity.
    As long as you know that's the direction you'll end up with.
    If you don't have the time though, scale.
  - Configuring the world
  - When to refactor? abstract
- Things I'd love to work on more
  - Inject team and user to `app-view` props
  - Designing the frontend
  - Bots
  - Broadcast channel validation.
  - Magic Login & How I'll do it.
  - Nintendo Polish
