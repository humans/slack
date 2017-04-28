<?php

namespace App\Http\Requests;

use App\Team;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * The messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => "\"{$this->name}\" is already taken by a channel, username, or user group.",
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => Rule::unique('channels')->where(function ($query) {
                $query->where('team_id', $this->team()->id);
            }),
        ];
    }

    /**
     * Return the team instance from the routing.
     *
     * Honestly, this isn't really necessary since we're binding the model in
     * the routing but for some reason, when we're doing our HTTP tests,
     * the model doesn't want to bind.
     *
     * At first, we explicitly set the bindings with `$this->instance` from
     * the test, but here, since we're taking it from the route method, if we
     * mock the route, we might end up fucking up everything else.
     *
     * So I think this is the best compromise we'll have _for now_ at least, to
     * make the tests pass.
     *
     * @return Team
     */
    private function team()
    {
        $team = $this->route()->parameter('team');

        if ($team instanceof Team) {
            return $team;
        }

        return Team::bySlug($team);
    }
}
