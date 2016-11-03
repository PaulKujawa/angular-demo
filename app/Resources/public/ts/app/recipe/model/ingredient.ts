import {Measurement} from "./measurement";
import {Product} from "./product";

export class Ingredient {
    constructor(public id: number,
                public position: number,
                public amount: number,
                public product: Product,
                public measurement: Measurement) {}
}