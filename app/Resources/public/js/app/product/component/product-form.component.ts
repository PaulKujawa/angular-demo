import {Component, Input, OnChanges, SimpleChanges} from '@angular/core';
import {FormBuilder, FormGroup} from '@angular/forms';
import {Router} from '@angular/router';
import {Observable} from 'rxjs/Observable';
import {ProductRequestDto} from '../model/dto/product-request.dto';
import {Product} from '../model/product';
import {ProductState} from '../service/product.state';

@Component({
    selector: 'product-form',
    template: `
        <form [formGroup]="productForm"
              (ngSubmit)="onSubmit()"
              novalidate>
            <section>
                <mat-checkbox formControlName="vegan">
                    {{'app.product.form.vegan'|trans}}
                </mat-checkbox>
            </section>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.name'|trans"
                       formControlName="name">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.manufacturer'|trans"
                       formControlName="manufacturer">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.gr'|trans"
                       type="number"
                       formControlName="gr">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.kcal'|trans"
                       type="number"
                       formControlName="kcal">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.carbs'|trans"
                       type="number"
                       step="0.1"
                       formControlName="carbs">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.fat'|trans"
                       type="number"
                       step="0.1"
                       formControlName="fat">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.protein'|trans"
                       type="number"
                       step="0.1"
                       formControlName="protein">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.sugar'|trans"
                       type="number"
                       step="0.1"
                       formControlName="sugar">
            </mat-form-field>
            <mat-form-field>
                <input matInput
                       [placeholder]="'app.product.form.gfat'|trans"
                       type="number"
                       step="0.1"
                       formControlName="gfat">
            </mat-form-field>

            <div>
                <button *ngIf="inputProduct"
                        mat-raised-button
                        color="warn"
                        (click)="onDelete(inputProduct)">
                    {{'app.common.delete' | trans}}
                </button>
                <button mat-raised-button
                        color="primary"
                        [disabled]="productForm.invalid">
                    {{'app.common.submit' | trans}}
                </button>
            </div>
        </form>
    `,
})
export class ProductFormComponent implements OnChanges {
    @Input('product') public inputProduct?: Product;
    public productForm: FormGroup;

    constructor(private router: Router,
                private formBuilder: FormBuilder,
                private productState: ProductState) {
        const placeholder = this.getConfig();
        this.productForm = this.formBuilder.group(placeholder);
    }

    public ngOnChanges(changes: SimpleChanges): void {
        if (changes.inputProduct) {
            const productConfig = this.getConfig();
            this.productForm.setValue(productConfig);
        }
    }

    public onSubmit(): void {
        const productDto: ProductRequestDto = this.productForm.value;

        const observable: Observable<any> = this.inputProduct
            ? this.productState.updateProduct(new Product({id: this.inputProduct.id, ...productDto}))
            : this.productState.addProduct(productDto);

        observable.subscribe(() => this.router.navigate(['products']));
    }

    public onDelete(product: Product): void {
        this.productState
            .removeProduct(product.id)
            .subscribe(() => this.router.navigate(['products']));
    }

    private getConfig(): object {
        const product = this.inputProduct;

        return {
            name: (product && product.name) || '',
            vegan: !!product && product.vegan,
            gr: (product && product.gr) || 0,
            kcal: (product && product.kcal) || 0,
            protein: (product && product.protein) || 0,
            carbs: (product && product.carbs) || 0,
            sugar: (product && product.sugar) || 0,
            fat: (product && product.fat) || 0,
            gfat: (product && product.gfat) || 0,
            manufacturer: (product && product.manufacturer ) || '',
        };
    }
}
