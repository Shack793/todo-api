import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { TodoList } from './TodoList';
import { TodoForm } from './TodoForm';
import { TodoSearchFilter } from './TodoSearchFilter';

export function TodoApp() {
    // Get filters from localStorage or use defaults
    const getInitialFilters = () => {
        const savedFilters = localStorage.getItem('todoFilters');
        return savedFilters ? JSON.parse(savedFilters) : {
            search: '',
            status: '',  // Empty string means "All"
            sort_by: 'created_at',
            order: 'desc'
        };
    };

    const [todos, setTodos] = useState([]);
    const [filters, setFilters] = useState(getInitialFilters());

    useEffect(() => {
        fetchTodos();
    }, [filters]);

    // Save filters to localStorage whenever they change
    useEffect(() => {
        localStorage.setItem('todoFilters', JSON.stringify(filters));
    }, [filters]);

    const fetchTodos = async () => {
        try {
            const params = new URLSearchParams(filters);
            const response = await axios.get(`/api/todos?${params}`);
            setTodos(response.data.todos);
        } catch (error) {
            console.error('Error fetching todos:', error);
        }
    };

    const handleCreateTodo = async (todoData) => {
        try {
            const response = await axios.post('/api/todos', todoData);
            setTodos(prevTodos => [...prevTodos, response.data.todo]);
        } catch (error) {
            console.error('Error creating todo:', error);
        }
    };

    const handleStatusChange = async (id, status) => {
        try {
            const response = await axios.put(`/api/todos/${id}`, { status });
            setTodos(prevTodos =>
                prevTodos.map(todo =>
                    todo.id === id ? response.data.todo : todo
                )
            );
        } catch (error) {
            console.error('Error updating todo:', error);
        }
    };

    const handleDelete = async (id) => {
        try {
            await axios.delete(`/api/todos/${id}`);
            setTodos(prevTodos => prevTodos.filter(todo => todo.id !== id));
        } catch (error) {
            console.error('Error deleting todo:', error);
        }
    };

    const handleFilterChange = (newFilters) => {
        setFilters(newFilters);
    };

    return (
        <div className="container mx-auto px-4 py-8">
            <h1 className="text-3xl font-bold mb-8">Todo List</h1>
            
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div className="md:col-span-2">
                    <TodoSearchFilter
                        filters={filters}
                        onFilterChange={handleFilterChange}
                    />
                    <TodoList
                        todos={todos}
                        onStatusChange={handleStatusChange}
                        onDelete={handleDelete}
                    />
                </div>
                
                <div>
                    <TodoForm onSubmit={handleCreateTodo} />
                </div>
            </div>
        </div>
    );
}
