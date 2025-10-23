<div>
	<label for="name" class="block text-sm font-medium leading-6 text-gray-900">Category Name</label>
	<div class="mt-2">
		<input type="text" name="name" id="name"
			class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-0 focus:border-transparent"
			value="{{ old('name', $category->name ?? null) }}">
	</div>
	@error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="flex justify-end mt-6">
	<a href="{{ route('admin.categories.index') }}"
		class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
	<button type="submit"
		class="ml-3 rounded-md bg-green-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700">Save</button>
</div>
