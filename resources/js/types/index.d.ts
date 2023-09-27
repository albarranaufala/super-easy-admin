export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    role: Role;
}

export interface Role {
    id: number;
    name: string;
    users_count?: number;
}

export interface Module {
    id: number;
    name: string;
    attributes?: Array<ModuleAttribute>;
    fillable_attributes?: Array<ModuleAttribute>;
}

export interface ModuleAttribute {
    id: number;
    type: string;
    name: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
    sidebar: {
        modules: Arary<Module>;
    };
};

export interface PaginatedData<T> {
    data: T[];
    from: number;
    to: number;
    total: number;
    links: Array<{
        url?: string;
        label: string;
        active: boolean;
    }>;
}

export interface SelectOption {
    label: string;
    value: string | number;
}
