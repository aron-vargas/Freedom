import { type BreadcrumbItem, type SharedData } from '@/types';
import { Transition } from '@headlessui/react';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';

import DeleteUser from '@/components/delete-user';
import HeadingSmall from '@/components/heading-small';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

type ProfileForm = {
    first_name: string;
    last_name: string;
    nickname: string;
    email: string;
    phone: string;
}

export default function Profile({ mustVerifyEmail, status }: { mustVerifyEmail: boolean; status?: string })
{
    const { auth } = usePage<SharedData>().props;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm<Required<ProfileForm>>({
        first_name: auth.user.first_name,
        last_name: auth.user.last_name,
        nickname: auth.user.nickname,
        email: auth.user.email,
        phone: auth.user.phone,
    });

    const submit: FormEventHandler = (e) =>
    {
        e.preventDefault();

        patch(route('profile.update'), {
            preserveScroll: true,
        });
    };

    const SetDateValue = (e: any) =>
    {
        setData(e.target.id, e.target.value);
    }
    //onChange={(e) => setData('name', e.target.value)}

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />
            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Profile information" description="Update your name and email address" />
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid gap-2">
                            <Label htmlFor="first_name">First Name</Label>
                            <Input id="first_name" className="mt-1 block w-full" value={data.first_name} required
                                onChange={SetDateValue} autoComplete="first_name" placeholder="First Name" />
                            <InputError className="mt-2" message={errors.first_name} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="last_name">Last Name</Label>
                            <Input id="last_name" className="mt-1 block w-full" value={data.last_name} required
                                onChange={SetDateValue} autoComplete="last_name" placeholder="Last Name" />
                            <InputError className="mt-2" message={errors.last_name} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="nickname">Nick Name</Label>
                            <Input id="nickname" className="mt-1 block w-full" value={data.nickname}
                                onChange={SetDateValue} autoComplete="nickname" placeholder="Nick Name" />
                            <InputError className="mt-2" message={errors.nickname} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="email">Email address</Label>
                            <Input id="email" type="email" className="mt-1 block w-full" value={data.email} required
                                onChange={SetDateValue} autoComplete="email" placeholder="Email address" />
                            <InputError className="mt-2" message={errors.email} />
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="phone">Phone address</Label>
                            <Input id="phone" type="phone" className="mt-1 block w-full" value={data.phone}
                                onChange={SetDateValue} autoComplete="phone" placeholder="Phone Number" />
                            <InputError className="mt-2" message={errors.phone} />
                        </div>

                        {mustVerifyEmail && auth.user.email_verified_at === null && (
                            <div>
                                <p className="text-muted-foreground -mt-4 text-sm">
                                    Your email address is unverified.{' '}
                                    <Link
                                        href={route('verification.send')} method="post" as="button"
                                        className="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500">
                                        Click here to resend the verification email.
                                    </Link>
                                </p>

                                {status === 'verification-link-sent' && (
                                    <div className="mt-2 text-sm font-medium text-green-600">
                                        A new verification link has been sent to your email address.
                                    </div>
                                )}
                            </div>
                        )}

                        <div className="flex items-center gap-4">
                            <Button disabled={processing}>Save</Button>
                            <Transition
                                show={recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0"
                                leave="transition ease-in-out" leaveTo="opacity-0">
                                <p className="text-sm text-neutral-600">Saved</p>
                            </Transition>
                        </div>
                    </form>
                </div>
                <DeleteUser />
            </SettingsLayout>
        </AppLayout>
    );
}
