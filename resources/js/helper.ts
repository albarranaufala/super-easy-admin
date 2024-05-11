export const getError = (errors: Record<string, any>, name: string): any => {
    return errors[name];
};

export const getDefaultOptions = () => [
    {
        name: "Option 1",
    },
    {
        name: "Option 2",
    },
    {
        name: "Option 3",
    },
];
