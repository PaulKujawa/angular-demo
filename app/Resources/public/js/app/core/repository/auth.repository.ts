import {HttpClient} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {ApiEventHandler} from '../service/api-event.handler';
import {RoutingService} from '../service/routing.service';

export interface Credentials {
    username: string;
    password: string;
}

@Injectable()
export class AuthRepository {
    constructor(private http: HttpClient,
                private apiEventHandler: ApiEventHandler,
                private routingService: RoutingService) {
    }

    public authenticate(credentials: Credentials): Observable<void> {
        const url = this.routingService.generate('fos_user_security_check');
        const body = {
            _username: credentials.username,
            _password: credentials.password,
        };

        return this.http.post<void>(url, body)
            .do(() => this.apiEventHandler.postSuccessMessage('app.auth.signed_in'))
            .catch((error) => this.apiEventHandler.catchError(error));
    }
}
