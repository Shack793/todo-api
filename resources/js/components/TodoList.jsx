import React from 'react';

export function TodoList({ todos, onStatusChange, onDelete }) {
    return (
        <div className="mt-4">
            {todos.map((todo) => (
                <div key={todo.id} className="bg-white p-4 rounded-lg shadow mb-4">
                    <div className="flex items-center justify-between">
                        <div>
                            <h3 className="text-lg font-semibold">{todo.title}</h3>
                            {todo.details && (
                                <p className="text-gray-600 mt-1">{todo.details}</p>
                            )}
                        </div>
                        <div className="flex items-center space-x-4">
                            <select
                                value={todo.status}
                                onChange={(e) => onStatusChange(todo.id, e.target.value)}
                                className="border rounded px-2 py-1"
                            >
                                <option value="not-started">Not Started</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            <button
                                onClick={() => onDelete(todo.id)}
                                className="text-red-500 hover:text-red-700"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
}
