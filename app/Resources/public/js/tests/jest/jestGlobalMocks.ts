const mock = () => {
    let storage: any = {};

    return {
        getItem: (key: any) => key in storage ? storage[key] : null,
        setItem: (key: any, value: any) => storage[key] = value || '',
        removeItem: (key: any) => delete storage[key],
        clear: () => storage = {},
    };
};

/*
 * Mocks are optional
 */
Object.defineProperty(window, 'localStorage', {value: mock()});
Object.defineProperty(window, 'sessionStorage', {value: mock()});

// Angular checks in which browser it runs
Object.defineProperty(window, 'getComputedStyle', {value: () => ['-webkit-appearance']});
