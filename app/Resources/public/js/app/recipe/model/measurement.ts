import {MeasurementDto} from './dto/measurement.dto';

export class Measurement {
    public id: number;
    public name: string;
    public gr: number;
    public created: Date;
    public updated: Date;

    constructor(dto: MeasurementDto) {
        this.id = dto.id;
        this.name = dto.name;
        this.gr = dto.gr;
        this.created = dto.created;
        this.updated = dto.updated;
    }
}
