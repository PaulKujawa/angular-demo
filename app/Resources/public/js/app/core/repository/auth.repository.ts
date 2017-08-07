import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {ApiEventHandler} from '../service/api-event.handler';
import {RoutingService} from '../service/routing.service';

export interface Credentials {
    username: string;
    password: string;
}

@Injectable()
export class AuthRepository {
    constructor(private http: Http,
                private apiEventHandler: ApiEventHandler,
                private routingService: RoutingService) {
    }

    public authenticate(credentials: Credentials): Observable<Response> {
        const url = this.routingService.generate('fos_user_security_check');
        const body = {
            _username: credentials.username,
            _password: credentials.password,
        };

        return this.http.post(url, body)
                   .do(() => this.apiEventHandler.postSuccessMessage('app.auth.signed_in'))
                   .catch((error) => this.apiEventHandler.catchError(error));
    }
}
