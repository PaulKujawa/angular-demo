import {Product} from '../../product/model/product';
import {Measurement} from './measurement';

export class Ingredient {
    constructor(public id: number,
                public position: number,
                public amount: number,
                public product: Product,
                public measurement: Measurement,
                public created: Date,
                public updated: Date) {}
}
