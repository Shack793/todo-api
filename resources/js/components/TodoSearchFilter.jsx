import React from 'react';

export function TodoSearchFilter({ filters, onFilterChange }) {
    const handleChange = (e) => {
        const { name, value } = e.target;
        onFilterChange({
            ...filters,
            [name]: value
        });
    };

    return (
        <div className="bg-white p-4 rounded-lg shadow mb-6">
            <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label htmlFor="search" className="block text-gray-700 font-bold mb-2">
                        Search
                    </label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value={filters.search}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Search todos..."
                    />
                </div>

                <div>
                    <label htmlFor="status" className="block text-gray-700 font-bold mb-2">
                        Status Filter
                    </label>
                    <select
                        id="status"
                        name="status"
                        value={filters.status}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    >
                        <option value="">All</option>
                        <option value="not-started">Not Started</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div>
                    <label htmlFor="sort_by" className="block text-gray-700 font-bold mb-2">
                        Sort By
                    </label>
                    <select
                        id="sort_by"
                        name="sort_by"
                        value={filters.sort_by}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    >
                        <option value="created_at">Date Created</option>
                        <option value="title">Title</option>
                        <option value="status">Status</option>
                    </select>
                </div>
            </div>
        </div>
    );
}
