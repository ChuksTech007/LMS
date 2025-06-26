<div>
	<label for="title" class="block text-sm font-medium leading-6 text-gray-900">Judul Kursus</label>
	<div class="mt-2">
		<input type="text" name="title" id="title"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
			value="{{ old('title', $course->title ?? null) }}">
	</div>
	@error('title')
		<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
	@enderror
</div>

<div>
	<label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
	<div class="mt-2">
		<textarea id="description" name="description" rows="4"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">{{ old('description', $course->description ?? null) }}</textarea>
	</div>
	@error('description')
		<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
	@enderror
</div>

<div>
	<label for="price" class="block text-sm font-medium leading-6 text-gray-900">Harga</label>
	<div class="mt-2">
		<input type="number" name="price" id="price"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
			value="{{ old('price', $course->price ?? null) }}">
	</div>
	@error('price')
		<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
	@enderror
</div>

<div>
	<label class="block text-sm font-medium leading-6 text-gray-900">Kategori</label>
	<p class="text-xs text-gray-500">Pilih satu atau lebih kategori yang relevan untuk kursus ini.</p>
	<div class="mt-2 space-y-2 border border-gray-200 rounded-md p-4">
		@foreach ($categories as $category)
			<div class="relative flex items-start">
				<div class="flex h-6 items-center">
					<input id="category-{{ $category->id }}" name="categories[]" value="{{ $category->id }}" type="checkbox"
						class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
						@checked(in_array($category->id, old('categories', $course->categories->pluck('id')->toArray() ?? [])))>
				</div>
				<div class="ml-3 text-sm leading-6">
					<label for="category-{{ $category->id }}"
						class="font-medium text-gray-900">{{ $category->name }}</label>
				</div>
			</div>
		@endforeach
	</div>
	@error('categories')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
	<label class="block text-sm font-medium leading-6 text-gray-900">Thumbnail Kursus</label>
	<div x-data="{ thumbnailPreview: '{{ isset($course) && $course->thumbnail ? asset('storage/' . $course->thumbnail) : '' }}' }"
		class="mt-2">
		<input type="file" name="thumbnail" id="thumbnail" class="sr-only" x-ref="thumbnail" @change="
                let reader = new FileReader();
                reader.onload = (e) => {
                    thumbnailPreview = e.target.result;
                };
                reader.readAsDataURL($refs.thumbnail.files[0]);
            ">

		<div x-show="thumbnailPreview" class="mb-2">
			<label class="block text-xs font-medium leading-6 text-gray-600">Pratinjau:</label>
			<img :src="thumbnailPreview" alt="Image Preview" class="h-40 w-auto rounded-md object-cover">
		</div>

		<div @click="$refs.thumbnail.click()" x-show="!thumbnailPreview"
			class="flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 hover:border-indigo-400 cursor-pointer">
			<div class="text-center">
				<svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
					<path fill-rule="evenodd"
						d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
						clip-rule="evenodd" />
				</svg>
				<div class="mt-4 flex text-sm leading-6 text-gray-600">
					<p class="pl-1">Unggah file atau tarik dan lepas</p>
				</div>
				<p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF hingga 2MB</p>
			</div>
		</div>

		<button type="button" @click="$refs.thumbnail.click()" x-show="thumbnailPreview"
			class="mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-500">
			Ganti Gambar
		</button>
	</div>
	@error('thumbnail')
		<p class="mt-2 text-sm text-red-600">{{ $message }}</p>
	@enderror
</div>

<div class="flex justify-end pt-6">
	<button type="submit"
		class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Simpan
		Kursus</button>
</div>