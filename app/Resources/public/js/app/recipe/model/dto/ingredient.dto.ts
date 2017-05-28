import {ProductResponseDto} from '../../../product/model/dto/product-response.dto';
import {MeasurementDto} from './measurement.dto';

export interface IngredientDto {
    id: number;
    position: number;
    amount?: number;
    product: ProductResponseDto;
    measurement?: MeasurementDto;
    kcal: number;
    created: Date;
    updated: Date;
}
