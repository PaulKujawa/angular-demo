import {IngredientDto} from './dto/ingredient.dto';
import {Measurement} from './measurement';
import {Product} from './product';

export class Ingredient {
    public id: number;
    public amount?: number;
    public product: Product;
    public measurement?: Measurement;
    public kcal: number;
    public created: Date;
    public updated: Date;

    constructor(dto: IngredientDto) {
        this.id = dto.id;
        this.product = new Product(dto.product);
        this.kcal = dto.kcal;
        this.created = dto.created;
        this.updated = dto.updated;

        if (dto.amount !== undefined) {
            this.amount = dto.amount;
        }

        if (dto.measurement) {
            this.measurement = new Measurement(dto.measurement);
        }
    }
}
