import {Injectable} from '@angular/core';
import {Http, URLSearchParams} from '@angular/http';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../../core/service/routing.service';
import {Product} from '../model/product';
import {Products} from '../model/products';

@Injectable()
export class ProductRepository {
    constructor(private http: Http,
                private routingService: RoutingService) {}

    getProducts(filter: Map<string, string>): Observable<Products> {
        const url = this.routingService.generate('api_get_products');
        const queryParameter = new URLSearchParams();

        filter.forEach((value: string, key: string) => queryParameter.set(key, value));

        return this.http.get(url, {search: queryParameter})
            .map(products => new Products(products.json()))
            .catch(error => Observable.throw(error.message || error.statusText));
    }

    getProduct(id: number): Observable<Product> {
        const url = this.routingService.generate('api_get_product', {'id': id});

        return this.http.get(url)
            .map(product => new Product(product.json()))
            .catch(error => Observable.throw(error.message || error.statusText));
    }
}
