import {ReplaySubject} from 'rxjs/ReplaySubject';
import {Pageable} from '../../core/model/pageable';
import {Product} from '../model/product';

export class ProductState {
    public pageable = new ReplaySubject<Pageable<Product>>(1);

    public replaceProduct(product: Product): void {
        this.pageable.take(1)
        .subscribe((pageable: Pageable<Product>) => {
            const i = pageable.docs.findIndex((p: Product) => p.id === product.id);
            pageable.docs.splice(i, i === -1 ? 0 : 1, product);
            this.pageable.next(pageable);
        });
    }

    public addProduct(product: Product): void {
        this.pageable.take(1)
        .subscribe((pageable: Pageable<Product>) => {
            pageable.docs.push(product);
            this.pageable.next(pageable);
        });
    }

    public removeProduct(id: number): void {
        this.pageable.take(1)
        .subscribe((pageable: Pageable<Product>) => {
            const i = pageable.docs.findIndex((p: Product) => p.id === id);
            pageable.docs.splice(i, i === -1 ? 0 : 1);
            this.pageable.next(pageable);
        });
    }
}
