import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {RoutingService} from "../../core/service/routing.service";
import {Jwt} from "../model/jwt";

@Injectable()
export class AuthRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {}

    authenticate(credentials: {username: string, password: string}): Observable<Jwt> {
        const url = this.routingService.generate('fos_user_security_check');
        const body = {
            _username: credentials.username,
            _password: credentials.password
        };

        return this.http.post(url, body)
            .map(recipes => recipes.json() || {} )
            .catch(error => {
                const body: {message: string, code: number} = error.json();
                return Observable.throw(body.message || error.message)
            });
    }
}
