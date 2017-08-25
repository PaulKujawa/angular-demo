import {BaseRequestOptions} from '@angular/http';

export class DefaultRequestOptions extends BaseRequestOptions {
    constructor() {
        super();

        if (this.headers) {
            this.headers.set('Content-Type', 'application/json');
        }
    }
}
