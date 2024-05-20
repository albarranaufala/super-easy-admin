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
}

export interface ModuleAttribute {
    id: number;
    type: string;
    name: string;
    additional_info?: {
        options: Array<{
            id: string;
            name: string;
        }> | null;
        reference_module_id: number | null;
    } | null;
    default_value: string;
    referenced_module_rows?: Array<{ [key: string]: string }>;
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
    value: any;
}
