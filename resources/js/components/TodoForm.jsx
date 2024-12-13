import React, { useState } from 'react';

export function TodoForm({ onSubmit }) {
    const [formData, setFormData] = useState({
        title: '',
        details: '',
        status: 'not-started'
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        onSubmit(formData);
        setFormData({
            title: '',
            details: '',
            status: 'not-started'
        });
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    return (
        <form onSubmit={handleSubmit} className="bg-white p-6 rounded-lg shadow">
            <div className="mb-4">
                <label htmlFor="title" className="block text-gray-700 font-bold mb-2">
                    Title
                </label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value={formData.title}
                    onChange={handleChange}
                    required
                    className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Enter todo title"
                />
            </div>

            <div className="mb-4">
                <label htmlFor="details" className="block text-gray-700 font-bold mb-2">
                    Details
                </label>
                <textarea
                    id="details"
                    name="details"
                    value={formData.details}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                    rows="3"
                    placeholder="Enter todo details (optional)"
                />
            </div>

            <div className="mb-4">
                <label htmlFor="status" className="block text-gray-700 font-bold mb-2">
                    Status
                </label>
                <select
                    id="status"
                    name="status"
                    value={formData.status}
                    onChange={handleChange}
                    className="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                >
                    <option value="not-started">Not Started</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <button
                type="submit"
                className="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none"
            >
                Add Todo
            </button>
        </form>
    );
}
