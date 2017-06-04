import {Injectable} from '@angular/core';
import {BaseRequestOptions} from '@angular/http';

@Injectable()
export class DefaultRequestOptions extends BaseRequestOptions {
    constructor() {
        super();

        if (this.headers) {
            this.headers.set('Content-Type', 'application/json');
        }
    }
}
