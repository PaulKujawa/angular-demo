import {MeasurementDto} from './measurement.dto';
import {ProductDto} from './product.dto';

export interface IngredientDto {
    id: number;
    amount?: number;
    product: ProductDto;
    measurement?: MeasurementDto;
    kcal: number;
    created: Date;
    updated: Date;
}
