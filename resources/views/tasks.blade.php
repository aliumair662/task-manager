<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-gray-100 p-6 font-sans">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">📝 Task Manager</h1>
        @if ($errors->any())
        <div class="mb-4 p-3 text-red-800 bg-red-100 border border-red-300 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        @if (session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded">
            {{ session('error') }}
        </div>
    @endif


        <form method="GET" action="/" class="mb-4">
            <label class="block mb-2 font-medium">Select Project:</label>
            <select name="project_id" onchange="this.form.submit()" class="w-full p-2 border border-gray-300 rounded">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $projectId == $project->id ? 'selected' : '' }}>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <form method="POST" action="/tasks" class="flex gap-2 mb-6">
            @csrf
            <input type="text" name="name" placeholder="New task..." class="flex-1 p-2 border rounded border-gray-300" required>
            <input type="hidden" name="project_id" value="{{ $projectId }}">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add</button>
        </form>

        <ul id="taskList" class="space-y-2">
            @foreach ($tasks as $task)
                <li data-id="{{ $task->id }}" class="bg-gray-100 p-4 rounded flex justify-between items-center shadow-sm cursor-move">
                     <span class="priority-number font-semibold text-gray-600 w-6 text-center">#{{ $task->priority }}</span>

                    <form method="POST" action="/tasks/{{ $task->id }}" class="flex items-center gap-2 w-full">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ $task->name }}" class="flex-1 p-2 border border-gray-300 rounded">
                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Update</button>
                    </form>
                    <form method="POST" action="/tasks/{{ $task->id }}" class="ml-2" onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        const taskList = document.getElementById('taskList');
            new Sortable(taskList, {
                animation: 150,
                onEnd: function () {
                    // Update the priority numbers on frontend
                    taskList.querySelectorAll('li').forEach((li, index) => {
                        const prioritySpan = li.querySelector('.priority-number');
                        if (prioritySpan) {
                            prioritySpan.textContent = '#' + (index + 1);
                        }
                    });

                    // Send updated order to backend
                    let order = [];
                    taskList.querySelectorAll('li').forEach((li) => {
                        order.push(li.dataset.id);
                    });

                    fetch('/tasks/reorder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });

    </script>
</body>
</html>
