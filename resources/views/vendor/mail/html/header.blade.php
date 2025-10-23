@props(['url'])
<tr>
	<td class="header">
		<a href="{{ $url }}" style="display: inline-block;">
			<img src="{{ config('app.url') . '/images/logo.png' }}" class="logo" alt="School Logo"
				style="height: 36px; width: auto; max-width: 100%;">
		</a>
	</td>
</tr>