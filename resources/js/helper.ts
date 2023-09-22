export const getError = (errors: Record<string, any>, name: string): any => {
    return errors[name];
};
