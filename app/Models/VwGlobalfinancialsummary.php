<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class VwGlobalfinancialsummary
 * 
 * @property int $total_transaksi_sukses
 * @property float|null $total_dana_masuk_global
 *
 * @package App\Models
 */
class VwGlobalfinancialsummary extends Model
{
	protected $table = 'vw_globalfinancialsummary';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'total_transaksi_sukses' => 'int',
		'total_dana_masuk_global' => 'float'
	];

	protected $fillable = [
		'total_transaksi_sukses',
		'total_dana_masuk_global'
	];
}
