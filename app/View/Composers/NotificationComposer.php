<?php

namespace App\View\Composers;

use Illuminate\View\View;

class NotificationComposer
{
	/**
	 * Bind data to the view.
	 */
	public function compose(View $view): void
	{
		if (auth()->check()) {
			$view->with('unreadNotifications', auth()->user()->unreadNotifications);
		} else {
			// Pass an empty collection for guests to prevent errors
			$view->with('unreadNotifications', collect());
		}
	}
}