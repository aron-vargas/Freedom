import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'User Administration',
        href: '/admin/user/list',
    },
];

type User = {
    id: number;
    first_name: string;
    last_name: string;
    nickname: string;
    email: string;
    phone: string;
    // Add other fields as needed
};

export default function UserList() {
    const [users, setUsers] = useState<User[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetch('/api/users?active=1')
            .then(res => res.json())
            .then(data => {
                setUsers(data);
                setLoading(false);
            });
    }, []);

    const handleDelete = (id: number) => {
        if (window.confirm('Are you sure you want to delete this user?')) {
            router.delete(`/admin/user/${id}`, {
                onSuccess: () => setUsers(users.filter(u => u.id !== id)),
            });
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="User Administration" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <div className="overflow-x-auto rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-white dark:bg-neutral-900">
                    <table className="min-w-full divide-y divide-gray-200 dark:divide-neutral-800">
                        <thead>
                            <tr>
                                <th className="px-4 py-2 text-left">Name</th>
                                <th className="px-4 py-2 text-left">Nickname</th>
                                <th className="px-4 py-2 text-left">Email</th>
                                <th className="px-4 py-2 text-left">Phone</th>
                                <th className="px-4 py-2 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {loading ? (
                                <tr>
                                    <td colSpan={5} className="px-4 py-4 text-center">Loading...</td>
                                </tr>
                            ) : users.length === 0 ? (
                                <tr>
                                    <td colSpan={5} className="px-4 py-4 text-center">No active users found.</td>
                                </tr>
                            ) : (
                                users.map(user => (
                                    <tr key={user.id} className="hover:bg-neutral-100 dark:hover:bg-neutral-800">
                                        <td className="px-4 py-2">{user.first_name} {user.last_name}</td>
                                        <td className="px-4 py-2">{user.nickname}</td>
                                        <td className="px-4 py-2">{user.email}</td>
                                        <td className="px-4 py-2">{user.phone}</td>
                                        <td className="px-4 py-2 space-x-2">
                                            <button
                                                className="text-blue-600 hover:underline"
                                                onClick={() => router.visit(`/admin/user/${user.id}/edit`)}
                                            >
                                                Edit
                                            </button>
                                            <button
                                                className="text-red-600 hover:underline"
                                                onClick={() => handleDelete(user.id)}
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                ))
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AppLayout>
    );
}
