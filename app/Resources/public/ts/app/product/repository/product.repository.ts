import {Http, URLSearchParams, Response, Headers, RequestOptions} from '@angular/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs/Observable';
import {RoutingService} from '../../core/service/routing.service';
import {Product} from '../model/product';
import {Products} from '../model/products';
import {ProductRequestDto} from '../model/dto/product-request.dto';

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

    putProduct(product: Product): Observable<Response> {
        const url = this.routingService.generate('api_put_product', {'id': product.id});
        const headers = new Headers({'Content-Type': 'application/json'}); // TODO set as general header
        const options = new RequestOptions({headers: headers});
        const productDto = new ProductRequestDto(product);

        return this.http.put(url, {product: productDto}, options)
            .catch(error => Observable.throw(error.message || error.statusText));
    }
}
