<section>
    <h2>{{ trans('Info') }}</h2>

    <div class="profile">
        <dl>
            <dt>Joined</dt>
            <dd><x-dates.formatted-date-time-component :date="$user->created_at" format="F j, Y" /></dl>
        </dl>
    </div>
</section>
