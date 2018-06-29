import {MeasurementDto} from 'app/recipe/model/dto/measurement.dto';
import {ProductDto} from 'app/recipe/model/dto/product.dto';

export interface IngredientDto {
    id: number;
    amount?: number;
    product: ProductDto;
    measurement?: MeasurementDto;
    kcal: number;
    created: Date;
    updated: Date;
}
