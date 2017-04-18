import {Injectable} from '@angular/core';
import {Http, Response} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../service/routing.service';

export interface Credentials {
    username: string;
    password: string;
}

@Injectable()
export class AuthRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {
    }

    public authenticate(credentials: Credentials): Observable<Response> {
        const url = this.routingService.generate('fos_user_security_check');
        const body = {
            _username: credentials.username,
            _password: credentials.password,
        };

        return this.http.post(url, body)
            .catch((error) => {
                const errorBody: {message: string, code: number} = error.json();

                return Observable.throw(errorBody.message || error.message);
            });
    }
}
