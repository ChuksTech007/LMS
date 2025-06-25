<div>
	<label for="title" class="block text-sm font-medium leading-6 text-gray-900">Judul Pelajaran</label>
	<div class="mt-2">
		<input type="text" name="title" id="title"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
			value="{{ old('title', $lesson->title ?? null) }}">
	</div>
	@error('title')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
	<label for="duration_in_minutes" class="block text-sm font-medium leading-6 text-gray-900">Durasi (menit)</label>
	<div class="mt-2">
		<input type="number" name="duration_in_minutes" id="duration_in_minutes"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
			value="{{ old('duration_in_minutes', $lesson->duration_in_minutes ?? null) }}">
	</div>
	@error('duration_in_minutes')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
	<label for="video_url" class="block text-sm font-medium leading-6 text-gray-900">URL Video (Opsional)</label>
	<div class="mt-2">
		<input type="url" name="video_url" id="video_url"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
			value="{{ old('video_url', $lesson->video_url ?? null) }}" placeholder="https://youtube.com/watch?v=xxxx">
	</div>
	@error('video_url')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
	<label for="content" class="block text-sm font-medium leading-6 text-gray-900">Konten Teks (Opsional)</label>
	<div class="mt-2">
		<textarea id="content" name="content" rows="8"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">{{ old('content', $lesson->content ?? null) }}</textarea>
	</div>
	@error('content')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="flex justify-end">
	<button type="submit"
		class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan
		Pelajaran</button>
</div>